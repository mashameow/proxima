<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Обработка обновления вопроса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_question'])) {
    $stmt = mysqli_prepare($db, "
        UPDATE questions 
        SET ID_users = ?, name = ?, email = ?, phone = ?, question = ?
        WHERE ID_question = ?
    ");
    mysqli_stmt_bind_param(
        $stmt, "issssi",
        $_POST['ID_users'],
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['question'],
        $_POST['ID_question']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: questions.php");
    exit;
}

// Удаление вопроса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_question'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM questions WHERE ID_question = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_question']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: questions.php");
    exit;
}

// Добавление нового вопроса
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_question'])) {
    $stmt = mysqli_prepare($db, "
        INSERT INTO questions (ID_users, name, email, phone, question) 
        VALUES (?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param(
        $stmt, "issss",
        $_POST['ID_users'],
        $_POST['name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['question']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: questions.php");
    exit;
}

// Получение вопросов
$result = mysqli_query($db, "SELECT * FROM questions ORDER BY ID_question DESC");
$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Вопросы</title>
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
    <h2 class="dashboard__title admin__title">Таблица "Вопросы"</h2>
    
    <!-- Форма для добавления нового вопроса -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_question" value="1">
      <h3>Добавить новый вопрос</h3>
      <input class='admin__input' type="number" name="ID_users" placeholder="ID пользователя" required>
      <input class='admin__input' type="text" name="name" placeholder="Имя" required>
      <input class='admin__input' type="email" name="email" placeholder="Email" required>
      <input class='admin__input' type="text" name="phone" placeholder="Телефон" required>
      <input class='admin__input' name="question" placeholder="Вопрос" required></input>
      <button type="submit" class="add-btn button">Добавить вопрос</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>ID Пользователя</th><th>Имя</th><th>Email</th><th>Телефон</th><th>Вопрос</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($questions as $question): ?>
        <tr data-id="<?= $question['ID_question'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_question" value="<?= $question['ID_question'] ?>">
            <input type="hidden" name="update_question" value="1">
            <td><?= $question['ID_question'] ?></td>
            <td><input type="number" name="ID_users" value="<?= $question['ID_users'] ?>" disabled></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($question['name']) ?>" disabled></td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($question['email']) ?>" disabled></td>
            <td><input type="text" name="phone" value="<?= htmlspecialchars($question['phone']) ?>" disabled></td>
            <td><input name="question" value="<?= htmlspecialchars($question['question']) ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $question['ID_question'] ?>" onclick="enableEdit('<?= $question['ID_question'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $question['ID_question'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить вопрос?')" style="display:inline;">
              <input type="hidden" name="ID_question" value="<?= $question['ID_question'] ?>">
              <button type="submit" name="delete_question" class="delete-btn">Удалить</button>
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
