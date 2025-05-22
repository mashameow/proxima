<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Обработка обновления услуги
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_servise'])) {
    $stmt = mysqli_prepare($db, "
        UPDATE servises 
        SET nameServises = ?, description = ?, features = ?, products = ?, price = ?
        WHERE ID_servises = ?
    ");
    mysqli_stmt_bind_param(
        $stmt, "ssssii",
        $_POST['nameServises'],
        $_POST['description'],
        $_POST['features'],
        $_POST['products'],
        $_POST['price'],
        $_POST['ID_servises']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: servises.php");
    exit;
}

// Удаление услуги
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_servise'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM servises WHERE ID_servises = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_servises']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: servises.php");
    exit;
}

// Добавление новой услуги
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_servise'])) {
    $stmt = mysqli_prepare($db, "
        INSERT INTO servises (nameServises, description, features, products, price) 
        VALUES (?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param(
        $stmt, "ssssi",
        $_POST['nameServises'],
        $_POST['description'],
        $_POST['features'],
        $_POST['products'],
        $_POST['price']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: servises.php");
    exit;
}

// Получение услуг
$result = mysqli_query($db, "SELECT * FROM servises ORDER BY ID_servises DESC");
$servises = [];
while ($row = mysqli_fetch_assoc($result)) {
    $servises[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Услуги</title>
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
    <h2 class="dashboard__title admin__title">Таблица "Услуги"</h2>
    
    <!-- Форма для добавления новой услуги -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_servise" value="1">
      <h3>Добавить новую услугу</h3>
      <input class='admin__input' type="text" name="nameServises" placeholder="Название услуги" required>
      <input class='admin__input' type="text" name="description" placeholder="Описание" required>
      <input class='admin__input' type="text" name="features" placeholder="Особенности" required>
      <input class='admin__input' type="text" name="products" placeholder="Продукты" required>
      <input class='admin__input' type="number" name="price" placeholder="Цена" required>
      <button type="submit" class="add-btn button">Добавить услугу</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>Название услуги</th><th>Описание</th><th>Особенности</th><th>Продукты</th><th>Цена</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($servises as $servise): ?>
        <tr data-id="<?= $servise['ID_servises'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_servises" value="<?= $servise['ID_servises'] ?>">
            <input type="hidden" name="update_servise" value="1">
            <td><?= $servise['ID_servises'] ?></td>
            <td><input type="text" name="nameServises" value="<?= htmlspecialchars($servise['nameServises']) ?>" disabled></td>
            <td><input type="text" name="description" value="<?= htmlspecialchars($servise['description']) ?>" disabled></td>
            <td><input type="text" name="features" value="<?= htmlspecialchars($servise['features']) ?>" disabled></td>
            <td><input type="text" name="products" value="<?= htmlspecialchars($servise['products']) ?>" disabled></td>
            <td><input type="number" name="price" value="<?= $servise['price'] ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $servise['ID_servises'] ?>" onclick="enableEdit('<?= $servise['ID_servises'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $servise['ID_servises'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить услугу?')" style="display:inline;">
              <input type="hidden" name="ID_servises" value="<?= $servise['ID_servises'] ?>">
              <button type="submit" name="delete_servise" class="delete-btn">Удалить</button>
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
