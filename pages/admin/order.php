<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Получение данных для выпадающих списков
$users = mysqli_query($db, "SELECT ID_users, name FROM users");
$servises = mysqli_query($db, "SELECT ID_servises, nameServises FROM servises");
$products = mysqli_query($db, "SELECT ID_products, nameProduct FROM products");
$statuses = mysqli_query($db, "SELECT ID_status, name FROM status");
// Обработка обновления заказа
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_order'])) {
    $stmt = mysqli_prepare($db, "
        UPDATE orders 
        SET ID_users = ?, ID_servises = ?, ID_products = ?, number = ?, created_at = ?, ID_status = ?, quantity = ?, completionDate = ?, bonusesPlus = ?, price = ?, total_price = ?, bonusesMinus = ?
        WHERE ID_orders = ?
    ");
    mysqli_stmt_bind_param(
        $stmt, "iiiisiisiddii",
        $_POST['ID_users'],       // i
        $_POST['ID_servises'],    // i
        $_POST['ID_products'],     // i
        $_POST['number'],         // i
        $_POST['created_at'],     // s
        $_POST['ID_status'],      // i
        $_POST['quantity'],       // i
        $_POST['completionDate'], // s
        $_POST['bonusesPlus'],    // i
        $_POST['price'],          // d
        $_POST['total_price'],    // d
        $_POST['bonusesMinus'],   // i
        $_POST['ID_orders']       // i (для WHERE)
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: order.php");
    exit;
}

// Добавление нового заказа
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_order'])) {
// Убедимся, что created_at в правильном формате
$created_at = $_POST['created_at'];
if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $created_at)) {
    $created_at = date('Y-m-d'); // если неверный формат — подставим текущую дату
}

$stmt = mysqli_prepare($db, "
    INSERT INTO orders (ID_users, ID_servises, ID_products, number, created_at, ID_status, quantity, completionDate, bonusesPlus, price, total_price, bonusesMinus) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
mysqli_stmt_bind_param(
    $stmt, "iiisssisdddi",
    $_POST['ID_users'],
    $_POST['ID_servises'],
    $_POST['ID_products'],
    $_POST['number'],
    $created_at,
    $_POST['ID_status'],
    $_POST['quantity'],
    $_POST['completionDate'],
    $_POST['bonusesPlus'],
    $_POST['price'],
    $_POST['total_price'],
    $_POST['bonusesMinus']
);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: order.php");
    exit;
}

// Удаление заказа
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_order'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM orders WHERE ID_orders = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_orders']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: order.php");
    exit;
}

// Получение заказов
$result = mysqli_query($db, "SELECT * FROM orders ORDER BY ID_orders DESC");
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Заказы</title>
  <link rel="stylesheet" href="../../style.css">
  <style>
    table { font-size: 16px; width: 100%; border-collapse: collapse; }
    td, th { padding: 1px; border: 1px solid #ccc; }
    input[type="text"], input[type="number"], input[type="date"], input[type="email"], input[type="float"] {
        width: 100%; box-sizing: border-box;
    }
    .edit-btn, .save-btn, .delete-btn, .add-btn {
        padding: 4px 10px;
        cursor: pointer;
    }
  </style>
  <script>
    function enableEdit(rowId) {
        document.querySelectorAll('[data-id="'+rowId+'"] input, [data-id="'+rowId+'"] select').forEach(el => {
            el.removeAttribute('disabled');
        });
        document.getElementById('edit-btn-' + rowId).style.display = 'none';
        document.getElementById('save-btn-' + rowId).style.display = 'inline-block';
    }
  </script>
</head>
<body>
<main class="admin">
  <aside class="admin__nav">
    <a href="./admin.php" class="admin__nav-link">
      <img src="../../src/img/logoBlack.png" alt="logo" class="admin__nav-img">
    </a>
    <ul class="admin__nav-list">
      <li><a href="./order.php" class="admin__nav-link header__nav-menu-link">Заказы</a></li>
      <li><a href="./users.php" class="admin__nav-link header__nav-menu-link">Пользователи</a></li>
      <li><a href="./questions.php" class="admin__nav-link header__nav-menu-link">Вопросы</a></li>
      <li><a href="./servises.php" class="admin__nav-link header__nav-menu-link">Услуги</a></li>
      <li><a href="./products.php" class="admin__nav-link header__nav-menu-link">Продукция</a></li>
      <li><a href="./status.php" class="admin__nav-link header__nav-menu-link">Статус</a></li>
      <li><a href="../account.php" class="admin__nav-link header__nav-menu-link">Выход</a></li>
    </ul>
  </aside>

  <section class="adminHero">
    <h2 class="admin__title">Таблица "Заказы"</h2>
    
    <!-- Форма для добавления нового заказа -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_order" value="1">
      <h3>Добавить новый заказ</h3>
      <select class='admin__input' name="ID_users" required>
        <option value="">Выберите пользователя</option>
        <?php while ($user = mysqli_fetch_assoc($users)): ?>
          <option value="<?= $user['ID_users'] ?>"><?= htmlspecialchars($user['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <select class='admin__input' name="ID_servises" required>
        <option value="">Выберите услугу</option>
        <?php while ($servise = mysqli_fetch_assoc($servises)): ?>
          <option value="<?= $servise['ID_servises'] ?>"><?= htmlspecialchars($servise['nameServises']) ?></option>
        <?php endwhile; ?>
      </select>
      <select class='admin__input' name="ID_products" required>
        <option value="">Выберите продукт</option>
        <?php while ($product = mysqli_fetch_assoc($products)): ?>
          <option value="<?= $product['ID_products'] ?>"><?= htmlspecialchars($product['nameProduct']) ?></option>
        <?php endwhile; ?>
      </select>
      <input class='admin__input' type="text" name="number" placeholder="Номер заказа" required>
      <input class='admin__input' type="date" name="created_at" value="Дата создания" required >

      <select class='admin__input' name="ID_status" required>
        <option value="">Выберите статус</option>
        <?php while ($status = mysqli_fetch_assoc($statuses)): ?>
          <option value="<?= $status['ID_status'] ?>"><?= htmlspecialchars($status['name']) ?></option>
        <?php endwhile; ?>
      </select>
      <input class='admin__input' type="number" name="quantity" placeholder="Количество" required>
      <input class='admin__input' type="date" name="completionDate" placeholder="Дата завершения" required>
      <input class='admin__input' type="number" name="bonusesPlus" placeholder="Бонусы плюс" required>
      <input class='admin__input' type="float" name="price" placeholder="Цена" required>
      <input class='admin__input' type="float" name="total_price" placeholder="Итоговая цена" required>
      <input class='admin__input' type="number" name="bonusesMinus" placeholder="Бонусы минус" required>
      <button type="submit" class="add-btn button">Добавить заказ</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>ID Пользователя</th><th>ID Услуги</th><th>ID Продукта</th><th>Номер заказа</th><th>Дата создания</th><th>ID Статуса</th><th>Кол-во</th><th>Дата завершения</th><th>Бонусы +</th><th>Цена</th><th>Итоговая цена</th><th>Бонусы -</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
        <tr data-id="<?= $order['ID_orders'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_orders" value="<?= $order['ID_orders'] ?>">
            <input type="hidden" name="update_order" value="1">
            <td><?= $order['ID_orders'] ?></td>
            <td>
              <select name="ID_users" disabled>
                <?php
                // Сброс курсора для выборки пользователей
                mysqli_data_seek($users, 0);
                while ($user = mysqli_fetch_assoc($users)): ?>
                  <option value="<?= $user['ID_users'] ?>" <?= $user['ID_users'] == $order['ID_users'] ? 'selected' : '' ?>><?= htmlspecialchars($user['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </td>
            <td>
              <select name="ID_servises" disabled>
                <?php
                // Сброс курсора для выборки услуг
                mysqli_data_seek($servises, 0);
                while ($servise = mysqli_fetch_assoc($servises)): ?>
                  <option value="<?= $servise['ID_servises'] ?>" <?= $servise['ID_servises'] == $order['ID_servises'] ? 'selected' : '' ?>><?= htmlspecialchars($servise['nameServises']) ?></option>
                <?php endwhile; ?>
              </select>
            </td>
            <td>
              <select name="ID_products" disabled>
                <?php
                // Сброс курсора для выборки продуктов
                mysqli_data_seek($products, 0);
                while ($product = mysqli_fetch_assoc($products)): ?>
                  <option value="<?= $product['ID_products'] ?>" <?= $product['ID_products'] == $order['ID_products'] ? 'selected' : '' ?>><?= htmlspecialchars($product['nameProduct']) ?></option>
                <?php endwhile; ?>
              </select>
            </td>
            <td><input type="text" name="number" value="<?= htmlspecialchars($order['number']) ?>" disabled></td>
            <td><input type="date" name="created_at" value="<?= $order['created_at'] ?>" disabled></td>

            <td>
              <select name="ID_status" disabled>
                <?php
                // Сброс курсора для выборки статусов
                mysqli_data_seek($statuses, 0);
                while ($status = mysqli_fetch_assoc($statuses)): ?>
                  <option value="<?= $status['ID_status'] ?>" <?= $status['ID_status'] == $order['ID_status'] ? 'selected' : '' ?>><?= htmlspecialchars($status['name']) ?></option>
                <?php endwhile; ?>
              </select>
            </td>
            <td><input type="number" name="quantity" value="<?= $order['quantity'] ?>" disabled></td>
            <td><input type="date" name="completionDate" value="<?= $order['completionDate'] ?>" disabled></td>
            <td><input type="number" name="bonusesPlus" value="<?= $order['bonusesPlus'] ?>" disabled></td>
            <td><input type="float" name="price" value="<?= $order['price'] ?>" disabled></td>
            <td><input type="float" name="total_price" value="<?= $order['total_price'] ?>" disabled></td>
            <td><input type="number" name="bonusesMinus" value="<?= $order['bonusesMinus'] ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $order['ID_orders'] ?>" onclick="enableEdit('<?= $order['ID_orders'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $order['ID_orders'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить заказ?')" style="display:inline;">
              <input type="hidden" name="ID_orders" value="<?= $order['ID_orders'] ?>">
              <button type="submit" name="delete_order" class="delete-btn">Удалить</button>
            </form>
            </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</main>
</body>
</html>
