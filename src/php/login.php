<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Проверка на существование пользователя
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($db, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Проверка на подтверждение почты
        if ($user['is_verified'] == 0) {
            echo "<script>alert('Пожалуйста, подтвердите вашу почту перед входом в личный кабинет.');</script>";
        } else {
            // Проверка пароля с хешированием
            if (password_verify($password, $user['password'])) {
                // Успешный вход
                $_SESSION['user_id'] = $user['ID']; // или другой идентификатор пользователя
                header('Location: http://localhost:5173/pages/account.php');
                exit();
            } else {
                echo "<script>alert('Неверный логин или пароль');</script>";
            }
        }
    } else {
        echo "<script>alert('Неверный логин или пароль');</script>";
    }
}
?>
