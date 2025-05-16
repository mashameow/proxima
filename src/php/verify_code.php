<?php
session_start();
header('Content-Type: application/json');

require_once './rate_limit.php';
if (!rateLimit('registration', 5, 60)) {
    echo json_encode(['success' => false, 'message' => 'Слишком много попыток регистрации. Подождите минуту.']);
    exit;
}

// Включаем отображение ошибок для диагностики
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $email = $_POST['email'];

    if (!isset($_SESSION['reg_user']) || !isset($_SESSION['reg_code'])) {
        echo json_encode(['success' => false, 'message' => 'Сессия истекла. Начните регистрацию заново.']);
        exit;
    }

    if ($code != $_SESSION['reg_code']) {
        echo json_encode(['success' => false, 'message' => 'Неверный код подтверждения.']);
        exit;
    }

    $user = $_SESSION['reg_user'];

    $name = $user['name'];
    $surname = $user['surname'];
    $phone = $user['phone'];
    $email = $user['email'];
    $password = $user['password'];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT); // Используем безопасное хеширование


    // Подключение к базе данных
    $conn = new mysqli("localhost", "root", "", "proxima");

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД']);
        exit;
    }
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Пользователь с таким email уже существует.']);
        exit;
    }

    // Добавление нового пользователя
    // В запросе 8 параметров: name, surname, phone, email, password, created_at, bonuses, role, status
    $stmt = $conn->prepare("INSERT INTO users (name, surname, phone, email, password, created_at, bonuses, role) VALUES (?, ?, ?, ?, ?, NOW(), 500, 0)");

    // Проверяем успешность подготовки запроса
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Ошибка подготовки запроса: ' . $conn->error]);
        exit;
    }

    // Привязываем параметры (5 строковых значений, включая хешированный пароль)
    $stmt->bind_param("sssss", $name, $surname, $phone, $email, $passwordHash);


    // Проверяем успешность выполнения запроса
    if ($stmt->execute()) {
        unset($_SESSION['reg_user']);
        unset($_SESSION['reg_code']);
        echo json_encode(['success' => true, 'message' => 'Регистрация успешна!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ошибка выполнения запроса: ' . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
