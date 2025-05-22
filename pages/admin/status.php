<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Обработка обновления статуса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_status'])) {
    $stmt = mysqli_prepare($db, "
        UPDATE status 
        SET name = ? 
        WHERE ID_status = ?
    ");
    mysqli_stmt_bind_param(
        $stmt, "si",
        $_POST['name'],
        $_POST['ID_status']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: status.php");
    exit;
}

// Удаление статуса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_status'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM status WHERE ID_status = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_status']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: status.php");
    exit;
}

// Добавление нового статуса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_status'])) {
    $stmt = mysqli_prepare($db, "
        INSERT INTO status (name) 
        VALUES (?)
    ");
    mysqli_stmt_bind_param($stmt, "s", $_POST['name']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: status.php");
    exit;
}

// Получение статусов
$result = mysqli_query($db, "SELECT * FROM status ORDER BY ID_status DESC");
$statuses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Статусы</title>
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
    <h2 class="dashboard__title admin__title">Таблица "Статусы"</h2>
    
    <!-- Форма для добавления нового статуса -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_status" value="1">
      <h3>Добавить новый статус</h3>
      <input class=' admin__input' type="text" name="name" placeholder="Название статуса" required>
      <button type="submit" class="add-btn button">Добавить статус</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>Название статуса</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($statuses as $status): ?>
        <tr data-id="<?= $status['ID_status'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_status" value="<?= $status['ID_status'] ?>">
            <input type="hidden" name="update_status" value="1">
            <td><?= $status['ID_status'] ?></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($status['name']) ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $status['ID_status'] ?>" onclick="enableEdit('<?= $status['ID_status'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $status['ID_status'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить статус?')" style="display:inline;">
              <input type="hidden" name="ID_status" value="<?= $status['ID_status'] ?>">
              <button type="submit" name="delete_status" class="delete-btn">Удалить</button>
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
