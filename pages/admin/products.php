<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Обработка обновления продукта
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_product'])) {
    $stmt = mysqli_prepare($db, "
        UPDATE products 
        SET nameProduct = ?, description = ?, specifications = ?, image = ?, icon = ?, price = ?
        WHERE ID_products = ?
    ");
    mysqli_stmt_bind_param(
        $stmt, "sssssii",
        $_POST['nameProduct'],
        $_POST['description'],
        $_POST['specifications'],
        $_POST['image'],
        $_POST['icon'],
        $_POST['price'],
        $_POST['ID_products']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: products.php");
    exit;
}

// Удаление продукта
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_product'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM products WHERE ID_products = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_products']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: products.php");
    exit;
}

// Добавление нового продукта
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_product'])) {
    $stmt = mysqli_prepare($db, "
        INSERT INTO products (nameProduct, description, specifications, image, icon, price) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param(
        $stmt, "sssssi",
        $_POST['nameProduct'],
        $_POST['description'],
        $_POST['specifications'],
        $_POST['image'],
        $_POST['icon'],
        $_POST['price']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: products.php");
    exit;
}

// Получение продуктов
$result = mysqli_query($db, "SELECT * FROM products ORDER BY ID_products DESC");
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Продукты</title>
  <link rel="stylesheet" href="../../style.css">
  <style>
    table { font-size: 16px; width: 100%; border-collapse: collapse; }
    td, th { padding: 8px; border: 1px solid #ccc; }

    .edit-btn, .save-btn, .delete-btn, .add-btn {
        padding: 4px 10px;
        cursor: pointer;
    }
  </style>
  <script>
    function enableEdit(rowId) {
        document.querySelectorAll('[data-id="'+rowId+'"] input').forEach(el => {
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
    <h2 class="dashboard__title admin__title">Таблица "Продукты"</h2>
    
    <!-- Форма для добавления нового продукта -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_product" value="1">
      <h3>Добавить новый продукт</h3>
      <input class='admin__input' type="text" name="nameProduct" placeholder="Название продукта" required>
      <input class='admin__input' type="text" name="description" placeholder="Описание" required>
      <input class='admin__input' type="text" name="specifications" placeholder="Спецификации" required>
      <input class='admin__input' type="text" name="image" placeholder="Изображение" required>
      <input class='admin__input' type="text" name="icon" placeholder="Иконка" required>
      <input class='admin__input' type="number" name="price" placeholder="Цена" required>
      <button type="submit" class="add-btn button">Добавить продукт</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>Название продукта</th><th>Описание</th><th>Спецификации</th><th>Изображение</th><th>Иконка</th><th>Цена</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $product): ?>
        <tr data-id="<?= $product['ID_products'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_products" value="<?= $product['ID_products'] ?>">
            <input type="hidden" name="update_product" value="1">
            <td><?= $product['ID_products'] ?></td>
            <td><input type="text" name="nameProduct" value="<?= htmlspecialchars($product['nameProduct']) ?>" disabled></td>
            <td><input type="text" name="description" value="<?= htmlspecialchars($product['description']) ?>" disabled></td>
            <td><input type="text" name="specifications" value="<?= htmlspecialchars($product['specifications']) ?>" disabled></td>
            <td><input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" disabled></td>
            <td><input type="text" name="icon" value="<?= htmlspecialchars($product['icon']) ?>" disabled></td>
            <td><input type="number" name="price" value="<?= $product['price'] ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $product['ID_products'] ?>" onclick="enableEdit('<?= $product['ID_products'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $product['ID_products'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить продукт?')" style="display:inline;">
              <input type="hidden" name="ID_products" value="<?= $product['ID_products'] ?>">
              <button type="submit" name="delete_product" class="delete-btn">Удалить</button>
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
