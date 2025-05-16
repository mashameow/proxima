<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');

if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Ошибка: пользователь не авторизован.");
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../style.css">
  <title>Загрузить проект</title>
</head>
<body>

<header class="header">
  <div class="header__container">
    <nav class="nav">
      <a href="../index.php"><img src="../src/img/logo2.png" alt="logo" class="header__nav-img"/></a>
      <ul class="header__nav-menu">
        <a href="./about.html" class="header__nav-menu-link SoyuzGrotesk">о нас</a>
        <a href="./servises.php" class="header__nav-menu-link SoyuzGrotesk">услуги</a>
        <a href="./aboutOrder.php" class="header__nav-menu-link SoyuzGrotesk">все о заказе</a>
        <a href="./contacts.html" class="header__nav-menu-link SoyuzGrotesk">контакты</a>
      </ul>
      <a href="./account.php" class="header__nav-account SoyuzGrotesk">Личный кабинет</a>
    </nav>
  </div>
</header>

<main>
  <section class="heroUpload">
    <div class="heroUpload__container container">
      <h2 class="heroUpload__title SoyuzGrotesk section-title">Загрузить проект</h2>
      <p class="heroUpload__text">Максимальный размер файла — 25 МБ</p>

      <form class="heroUpload__form" action="../src/php/upload_form/upload_handler.php" method="POST" enctype="multipart/form-data" id="uploadForm">
        <div class="heroUpload__form-file">
          <label class="heroUpload__form-file-lable" id="fileLabel" for="fileInput">
            <span class="heroUpload__form-file-label-text">Добавить файл</span>
          </label>
          <input class="heroUpload__form-file-input" type="file" name="file[]" id="fileInput" multiple required>
          <label class="heroUpload__form-file-custom" for="fileInput">
            <img src="/../src/icon/Attach.png" alt="Загрузить файл">
          </label>
        </div>
        <textarea class="heroUpload__form-custom-comment" placeholder="Комментарий" name="comment" rows="5" cols="40" required></textarea><br><br>
        <button type="submit" class="heroUpload__form-button button">Отправить</button>
      </form>

      <div class="heroUpload__exit exit-block">
        <a href="../pages/account.php" class="heroUpload__exit-btn exit button">Назад</a>
      </div>
    </div>
  </section>
</main>

<footer class="footer">
  <div class="footer__container">
    <nav class="nav">
      <a href="../index.php"><img src="../src/img/logo2.png" alt="logo" class="footer__nav-img"/></a>
      <ul class="footer__nav-menu">
        <a href="./about.php" class="footer__nav-menu-link SoyuzGrotesk">о нас</a>
        <a href="./servises.php" class="footer__nav-menu-link SoyuzGrotesk">услуги</a>
        <a href="./aboutOrder.php" class="footer__nav-menu-link SoyuzGrotesk">все о заказе</a>
        <a href="./contacts.html" class="footer__nav-menu-link SoyuzGrotesk">контакты</a>
      </ul>
      <a href="./pages/account.php" class="footer__nav-account SoyuzGrotesk">Личный кабинет</a>
    </nav>
  </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('uploadForm');
  const fileInput = document.getElementById('fileInput');
  const fileLabelText = document.querySelector('#fileLabel .heroUpload__form-file-label-text');

  // Функция для сокращения длинного имени файла
  const truncateFileName = (name, maxLength = 30) => {
    return name.length > maxLength ? name.substring(0, maxLength - 3) + '...' : name;
  };

 form.addEventListener('submit', (e) => {
  let oversize = false;

  for (let file of fileInput.files) {
    if (file.size > 25 * 1024 * 1024) {
      oversize = true;
      break;
    }
  }

  if (oversize) {
    e.preventDefault();
    alert('Один из файлов превышает допустимый размер 25 МБ.');
    fileInput.value = ''; // Сброс файлов
    fileLabelText.textContent = 'Добавить файл';
  }
});

  // Обработка изменения файлов
  fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    if (files.length === 0) {
      fileLabelText.textContent = 'Добавить файл';
    } else if (files.length === 1) {
      fileLabelText.textContent = truncateFileName(files[0].name);
    } else {
      const firstFileName = truncateFileName(files[0].name);
      fileLabelText.textContent = `${firstFileName} и ещё ${files.length - 1}`;
    }
  });
});
</script>

</body>
</html>
