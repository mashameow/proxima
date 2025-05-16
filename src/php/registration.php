<?php
session_start();
header('Content-Type: application/json');

// Включаем отображение ошибок
ini_set('display_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем и обрабатываем данные
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $surname = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Валидация
    if (!$name || !$surname || !$phone || !$email || !$password) {
        echo json_encode(['success' => false, 'message' => 'Все поля обязательны для заполнения.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Некорректный email.']);
        exit;
    }

    if (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        echo json_encode(['success' => false, 'message' => 'Некорректный номер телефона.']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'message' => 'Пароль должен быть не менее 6 символов.']);
        exit;
    }

    // Проверка email в БД
    $conn = new mysqli("localhost", "root", "", "proxima");

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Ошибка подключения к базе данных.']);
        exit;
    }

    $stmt = $conn->prepare("SELECT ID_users FROM users WHERE email = ?");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Ошибка подготовки запроса: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует.']);
        $stmt->close();
        $conn->close();
        exit;
    }

    $stmt->close();
    $conn->close();

    // Генерация и сохранение кода
    $code = rand(100000, 999999);
    $_SESSION['reg_user'] = $_POST;
    $_SESSION['reg_code'] = $code;

    // Отправка письма
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'rassiainmyheart@gmail.com';
        $mail->Password = 'jsuv unfg eadp plfa'; // пароль приложения
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('rassiainmyheart@gmail.com', 'PROXIMA');
        $mail->addAddress($email);
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = 'Код подтверждения регистрации на сайте типографии PROXIMA';

        $mail->Body = "
        <html>
        <head><style>.code { font-weight: 700; color: #e93ea3; font-size: 20px; }</style></head>
        <body>
            <h1>Подтверждение регистрации</h1>
            <p>Введите следующий код:</p>
            <p class='code'>$code</p>
            <p>Если вы не запрашивали код — проигнорируйте это письмо.</p>
        </body>
        </html>";

        $mail->send();
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Ошибка отправки письма: ' . $mail->ErrorInfo]);
    }
}
