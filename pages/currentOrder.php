<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');

// Проверка на ошибки подключения к базе данных
if (!$db) {
    die("<script>alert('Ошибка подключения к базе данных: " . mysqli_connect_error() . "');</script>");
}

// Получаем ID пользователя из сессии (предполагается, что он уже установлен)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("<p>Ошибка: пользователь не авторизован.</p>");
}

// Подготавливаем SQL-запрос с JOIN для получения имен услуг, продуктов и статуса
$order_stmt = $db->prepare("SELECT o.*, s.nameServises, p.nameProduct, st.name FROM orders o
    JOIN Servises s ON o.ID_servises = s.ID_servises
    JOIN Products p ON o.ID_products = p.ID_products
    JOIN Status st ON o.ID_status = st.ID_status
    WHERE o.ID_users = ? AND o.ID_status != 4");

if (!$order_stmt) {
    die("<p>Ошибка подготовки запроса: " . $db->error . "</p>");
}

$order_stmt->bind_param("i", $user_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Статус заказа</title>
</head>
<body>
<header class="header">
    <div class="header__container">
        <nav class="nav">
            <a href="../index.html">
                <img src="../src/img/logo2.png" alt="logo" class="header__nav-img">
            </a>
            <ul class="header__nav-menu">
                <li><a href="./about.html" class="header__nav-menu-link SoyuzGrotesk">О нас</a></li>
                <li><a href="./servises.php" class="header__nav-menu-link SoyuzGrotesk">Услуги</a></li>
                <li><a href="./page/contacts.html" class="header__nav-menu-link SoyuzGrotesk">Все о заказе</a></li>
                <li><a href="./page/help.html" class="header__nav-menu-link SoyuzGrotesk">Контакты</a></li>
            </ul>
            <a href="./account.php" class="header__nav-account SoyuzGrotesk">Личный кабинет</a>
        </nav>
    </div>
</header>

<main>
    <section class="heroCurrentOrder">
        <div class="heroCurrentOrder__container container">
            <h2 class="heroCurrentOrder__title SoyuzGrotesk section-title">Статус заказа</h2>
            <p class="heroCurrentOrder__text">В этом разделе вы можете просмотреть статус ваших заказов</p>
            <div class="heroCurrentOrder__info">

            <?php
            if ($order_result->num_rows > 0) {
                while ($order = $order_result->fetch_assoc()) {
                    echo '<div class="heroCurrentOrder__block">';
                    echo '<h3 class="heroCurrentOrder__block-title">Заказ №' . htmlspecialchars($order['ID_orders']) . '</h3>';
                    echo '<p class="heroCurrentOrder__block-text">';
                    echo 'Номер заказа: ' . htmlspecialchars($order['number']) . ', ';
                    echo 'Дата заказа: ' . htmlspecialchars($order['created_at']) . ', ';
                    echo 'Услуга: ' . htmlspecialchars($order['nameServises']) . ', ';
                    echo 'Продукция: ' . htmlspecialchars($order['nameProduct']) . ', ';
                    echo 'Количество: ' . htmlspecialchars($order['quantity']) . ' шт., ';
                    echo 'Статус: ' . htmlspecialchars($order['name']) . ', ';
                    echo 'Ожидаемая дата завершения: ' . htmlspecialchars($order['completionDate']) . ', ';
                    echo 'Цена (до учета скидок): ' . htmlspecialchars($order['price']) . ' руб.';
                    echo 'Списанные бонусы: ' . htmlspecialchars($order['bonusesMinus']) . ', ';
                    echo 'Полученные бонусы: ' . htmlspecialchars($order['bonusesPlus']) . ', ';
                    echo 'Итоговая цена: ' . htmlspecialchars($order['total_price']) . ', ';
                    echo '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>У вас нет активных заказов.</p>';
            }

            $order_stmt->close();
            $db->close();
            ?>
            </div>

            <div class="heroCurrentOrder__exit exit-block">
                <a href="../pages/account.php" class="heroCurrentOrder__exit-btn exit button" >Назад</a>
            </div>
        </div>
    </section>
</main>

<footer class="footer">
    <div class="footer__container">
        <nav class="nav">
            <a href="../index.html">
                <img src="../src/img/logo2.png" alt="logo" class="footer__nav-img">
            </a>
            <ul class="footer__nav-menu">
                <li><a href="./about.html" class="footer__nav-menu-link SoyuzGrotesk">О нас</a></li>
                <li><a href="./servises.php" class="footer__nav-menu-link SoyuzGrotesk">Услуги</a></li>
                <li><a href="./page/contacts.html" class="footer__nav-menu-link SoyuzGrotesk">Все о заказе</a></li>
                <li><a href="./page/help.html" class="footer__nav-menu-link SoyuzGrotesk">Контакты</a></li>
            </ul>
            <a href="./account.php" class="footer__nav-account SoyuzGrotesk">Личный кабинет</a>
        </nav>
    </div>
</footer>
<script type="module" src="/main.js"></script>
</body>
</html>
