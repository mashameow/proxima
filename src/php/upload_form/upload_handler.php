<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) die("Ошибка подключения: " . mysqli_connect_error());

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) die("Ошибка: пользователь не авторизован.");

// Получаем email и номер телефона из БД
$stmt = $db->prepare("SELECT email, phone FROM users WHERE ID_users = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($user_email, $user_phone);  // Добавил переменную для номера телефона
$stmt->fetch();
$stmt->close();

// Проверка файла
$maxSize = 25 * 1024 * 1024; // 25 MB

if (!isset($_FILES['file'])) {
  die("Файлы не загружены.");
}

foreach ($_FILES['file']['error'] as $index => $error) {
  if ($error !== UPLOAD_ERR_OK) {
    die("Ошибка при загрузке файла №$index");
  }

  if ($_FILES['file']['size'][$index] > $maxSize) {
    die("Файл №$index превышает допустимый размер 25 МБ.");
  }
}
$comment = htmlspecialchars($_POST['comment']);
require __DIR__ . '/../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
  $mail->isSMTP();
  $mail->Host       = 'smtp.gmail.com';
  $mail->SMTPAuth   = true;
  $mail->Username   = 'rassiainmyheart@gmail.com';
  $mail->Password   = 'jsuv unfg eadp plfa'; // App Password
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  $mail->Port       = 465;

  $mail->setFrom('rassiainmyheart@gmail.com', 'PROXIMA');
  $mail->addAddress('rassiainmyheart@gmail.com');
  $mail->CharSet = 'UTF-8';
  $mail->isHTML(true);
  $mail->Subject = "Новый файл от $user_email";
  $mail->Body    = "Комментарий:<br><pre>$comment</pre><br>Email пользователя: $user_email<br>Номер телефона пользователя: $user_phone";  

  // Добавляем все файлы как вложения
  foreach ($_FILES['file']['tmp_name'] as $index => $tmpPath) {
    $originalName = $_FILES['file']['name'][$index];
    $mail->addAttachment($tmpPath, basename($originalName));
  }

  $mail->send();
  echo "<script>alert('Файлы и комментарий успешно отправлены!'); window.history.back();</script>";
} catch (Exception $e) {
  echo "<script>alert('Ошибка при отправке: {$mail->ErrorInfo}'); window.history.back();</script>";
}
