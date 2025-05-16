<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');

if (!$db) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    die("Ошибка: пользователь не авторизован.");
}

$bonus_stmt = $db->prepare("SELECT bonuses FROM users WHERE ID_users = ?");
if (!$bonus_stmt) {
    die("Ошибка подготовки запроса: " . $db->error);
}

$bonus_stmt->bind_param("i", $user_id);
$bonus_stmt->execute();
$bonus_stmt->bind_result($bonuses);
$bonus_stmt->fetch();
$bonus_stmt->close();
$db->close();

function getBonusWord($number) {
    $number = abs($number) % 100;
    $n1 = $number % 10;

    if ($number > 10 && $number < 20) {
        return 'бонусов';
    }
    if ($n1 > 1 && $n1 < 5) {
        return 'бонуса';
    }
    if ($n1 == 1) {
        return 'бонус';
    }
    return 'бонусов';
}

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
          <a href="../index.php">
            <img
              src="../src/img/logo2.png"
              alt="logo"
              class="header__nav-img"
            />
          </a>
          <ul class="header__nav-menu">
            <a href="./about.html" class="header__nav-menu-link SoyuzGrotesk"
              >о нас</a
            >
            <a href="./servises.php" class="header__nav-menu-link SoyuzGrotesk"
              >услуги</a
            >
            <a
              href="./aboutOrder.php"
              class="header__nav-menu-link SoyuzGrotesk"
              >все о заказе</a
            >
            <a
              href="./contacts.html"
              class="header__nav-menu-link SoyuzGrotesk"
              >контакты</a
            >
          </ul>

          <a href="./account.php" class="header__nav-account SoyuzGrotesk"
            >Личный кабинет</a
          >
        </nav>
    </div>
</header>

<main>
    <section class="heroBonuses">
        <div class="heroBonuses__container container">
            <h2 class="heroBonuses__title SoyuzGrotesk section-title">Ваши бонусы</h2>
            <p class="heroBonuses__text">Добро пожаловать на страницу "Ваши бонусы"! Мы ценим вашу лояльность и хотим, чтобы вы получили максимальную выгоду от сотрудничества с нами. Здесь вы найдете информацию о том, как накапливать и использовать ваши бонусы.</p>
            <p class="heroBonuses__subtitle ">У вас сейчас:</p>
            <div class="heroBonuses__bonuses">
                <p class="heroBonuses__bonuses-title"><?php echo $bonuses . ' ' . getBonusWord($bonuses); ?></p>

                <p class="heroBonuses__bonuses-text">1 бонус = 1 рубль</p>
            </div>
            <p class="heroBonuses__subtitle">Как получить бонусы:</p>
            <p class="heroBonuses__info"> <span class="heroBonuses__info-span">1.</span> Регистрация: Присоединяйтесь к нашей программе лояльности, зарегистрировавшись на нашем сайте. После подтверждения вашей регистрации вы автоматически получите приветственный бонус. <br>
<span class="heroBonuses__info-span">2.</span> Покупки: За каждую покупку вы будете зарабатывать бонусы. Чем больше сумма вашей покупки, тем больше бонусов вы получите! Обычно начисление происходит в процентном соотношении от стоимости заказа.</p>
            <p class="heroBonuses__textLast">Бонусы имеют срок действия, поэтому следите за их использованием, чтобы не упустить возможность воспользоваться ими.</p>
            
            

            <div class="heroBonuses__exit exit-block">
                <a href="../pages/account.php" class="heroBonuses__exit-btn exit button" >Назад</a>
            </div>
        </div>
    </section>
</main>
<footer class="footer">
    <div class="footer__container">
        <nav class="nav">
          <a href="../index.php">
            <img src="../src/img/logo2.png" alt="logo" class="footer__nav-img" />
          </a>
          <ul class="footer__nav-menu">
            <a href="./about.php" class="footer__nav-menu-link SoyuzGrotesk"
              >о нас</a
            >
            <a href="./servises.php" class="footer__nav-menu-link SoyuzGrotesk"
              >услуги</a
            >
            <a
              href="./aboutOrder.php"
              class="footer__nav-menu-link SoyuzGrotesk"
              >все о заказе</a
            >
            <a href="./contacts.html" class="footer__nav-menu-link SoyuzGrotesk"
              >контакты</a
            >
          </ul>

          <a href="./pages/account.php" class="footer__nav-account SoyuzGrotesk"
            >Личный кабинет</a
          >
        </nav>
    </div>
</footer>
<script type="module" src="/main.js"></script>
</body>
</html>
