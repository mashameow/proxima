<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Обработка обновления пользователя
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update_user'])) {
    // Если пароль не пустой, обновляем его
    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    } else {
        // Если пароль пустой, оставляем старый
        $hashed_password = null;
    }
    $stmt = mysqli_prepare($db, "
        UPDATE users 
        SET name = ?, surname = ?, phone = ?, email = ?, bonuses = ?, role = ?" . 
        ($hashed_password ? ", password = ?" : "") . "
        WHERE ID_users = ?
    ");
    if ($hashed_password) {
        mysqli_stmt_bind_param(
            $stmt, "ssissisi",
            $_POST['name'],
            $_POST['surname'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['bonuses'],
            $_POST['role'],
            $hashed_password,
            $_POST['ID_users']
        );
    } else {
        mysqli_stmt_bind_param(
            $stmt, "ssissssi",
            $_POST['name'],
            $_POST['surname'],
            $_POST['phone'],
            $_POST['email'],
            $_POST['bonuses'],
            $_POST['role'],
            $_POST['ID_users']
        );
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: users.php");
    exit;
}

// Удаление пользователя
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete_user'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM users WHERE ID_users = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_users']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: users.php");
    exit;
}

// Добавление нового пользователя
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_user'])) {
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmt = mysqli_prepare($db, "
        INSERT INTO users (name, surname, phone, email, password, created_at, bonuses, role) 
        VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)
    ");
    mysqli_stmt_bind_param(
        $stmt, "ssissis",
        $_POST['name'],
        $_POST['surname'],
        $_POST['phone'],
        $_POST['email'],
        $hashed_password,
        $_POST['bonuses'],
        $_POST['role']
    );
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: users.php");
    exit;
}

// Получение пользователей
$result = mysqli_query($db, "SELECT * FROM users ORDER BY ID_users DESC");
$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель - Пользователи</title>
  <link rel="stylesheet" href="../../style.css">
  <style>
    table { font-size: 16px; width: 100%; border-collapse: collapse; }
    td, th { padding: 8px; border: 1px solid #ccc; }
    input[type="text"], input[type="number"], input[type="email"], input[type="password"] {
        width: 100%; box-sizing: border-box;
    }
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
        
        // Показать расшифрованный пароль
        const passwordInput = document.querySelector('[data-id="'+rowId+'"] input[name="password"]');
        passwordInput.type = 'text'; // Изменяем тип на текст
        passwordInput.placeholder = ''; // Убираем плейсхолдер
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
    <h2 class="dashboard__title admin__title">Таблица "Пользователи"</h2>
    
    <!-- Форма для добавления нового пользователя -->
    <form method="POST" class='admin__add' style="margin-bottom: 20px;">
      <input type="hidden" name="add_user" value="1">
      <h3>Добавить нового пользователя</h3>
      <input class='input admin__input' type="text" name="name" placeholder="Имя" required>
      <input class='input admin__input' type="text" name="surname" placeholder="Фамилия" required>
      <input class='input admin__input' type="text" name="phone" placeholder="Телефон" required>
      <input class='input admin__input' type="email" name="email" placeholder="Email" required>
      <input class='input admin__input' type="password" name="password" placeholder="Пароль" required>
      <input class='input admin__input' type="number" name="bonuses" placeholder="Бонусы" required>
      <input class='input admin__input' type="number" name="role" placeholder="Роль" required>
      <button type="submit" class="add-btn button">Добавить пользователя</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>ID</th><th>Имя</th><th>Фамилия</th><th>Телефон</th><th>Email</th><th>Пароль</th><th>Бонусы</th><th>Роль</th><th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
        <tr data-id="<?= $user['ID_users'] ?>">
          <form method="POST">
            <input type="hidden" name="ID_users" value="<?= $user['ID_users'] ?>">
            <input type="hidden" name="update_user" value="1">
            <td><?= $user['ID_users'] ?></td>
            <td><input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" disabled></td>
            <td><input type="text" name="surname" value="<?= htmlspecialchars($user['surname']) ?>" disabled></td>
            <td><input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" disabled></td>
            <td><input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" disabled></td>
            <td><input class='pass' type="text" name="password" placeholder="<?= htmlspecialchars($user['password']) ?>"  disabled></td>
            <td><input type="number" name="bonuses" value="<?= $user['bonuses'] ?>" disabled></td>
            <td><input type="number" name="role" value="<?= $user['role'] ?>" disabled></td>
            <td>
              <button type="button" class="edit-btn" id="edit-btn-<?= $user['ID_users'] ?>" onclick="enableEdit('<?= $user['ID_users'] ?>')">Изменить</button>
              <button type="submit" class="save-btn" id="save-btn-<?= $user['ID_users'] ?>" style="display:none;">Сохранить</button>
            </form>
            <form method="POST" onsubmit="return confirm('Удалить пользователя?')" style="display:inline;">
              <input type="hidden" name="ID_users" value="<?= $user['ID_users'] ?>">
              <button type="submit" name="delete_user" class="delete-btn">Удалить</button>
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
