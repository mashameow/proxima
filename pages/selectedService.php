<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');
$service_id = $_GET['id'];
$_SESSION['service_id'] = $service_id;

// Проверка на ошибки подключения к базе данных
if ($db == false) {
    echo "<script>alert('Ошибка подключения к базе данных');</script>";
    exit(); // Прекращаем выполнение скрипта, так как база недоступна
}

// Получаем данные о услуге из базы данных
$service_stmt = $db->prepare("SELECT * FROM servises WHERE ID_servises = ?");
$service_stmt->bind_param("i", $service_id);
$service_stmt->execute();
$service_result = $service_stmt->get_result();

if ($service_result->num_rows > 0) {
    $service_data = $service_result->fetch_assoc();

    $_SESSION['nameServises'] = $service_data['nameServises'];
    $_SESSION['description'] = $service_data['description'];
    $_SESSION['features'] = $service_data['features'];
    $_SESSION['products'] = $service_data['products'];
} else {
    echo "<script>alert('Услуга не найдена'); history.go(-1);</script>";
    exit(); // Прекращаем выполнение скрипта, так как услуга не найдена
}

// Закрываем соединение с базой данных
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title><?php echo $_SESSION['nameServises']; ?></title>
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
        <section class="heroSelectedService">
            <div class="heroSelectedService__container container">
                <h2 class="heroSelectedService__title section-title"><?php echo $_SESSION['nameServises']; ?></h2>
                <p class="heroSelectedService__description"><?php echo $_SESSION['description']; ?></p>
                <h3 class="heroSelectedProduct__text section-title">Особенности и достоинства:</h3>
                <p class="heroSelectedService__features"><?php echo $_SESSION['features']; ?></p>
                <h3 class="heroSelectedProduct__text section-title">Продукция:</h3>
                <p class="heroSelectedService__products"><?php echo $_SESSION['products']; ?></p>
                <div class="heroSelectedService__exit exit-block">
                    <button class="heroSelectedService__exit-btn exit button" onclick="history.back();">назад</button>
                </div>
            </div>
        </section>
        <section class="order">
            <div class="order__container container">
                <div class="order__info">
                    <h2 class="order__info-title SoyuzGrotesk section-title">Хотите оформить заказ?</h2>
                    <p class="order__info-text">
                        Мы рады приветствовать вас на сайте нашей типографии! <br />
                        Для вашего удобства мы подготовили раздел
                        <a href="./page/contacts.html" class="order__info-text-link SoyuzGrotesk">все о заказе</a>, где вы сможете найти всю необходимую информацию о том, как оформить заказ и пройти все его этапы.
                    </p>
                    <a href="./page/contacts.html" class ="button">подробнее</a>
                </div>
                <img src="../src/img/megaphone.png" alt="megaphone" class="order__img" />
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="footer__container">
            <nav class="nav">
					<a href="../index.php">
						<img src="./src/img/logo2.png" alt="logo" class="footer__nav-img" />
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
            <div class="footer__info">
                <div class="footer__info-text">
                    <p class="footer__info-text-p SoyuzGrotesk">(903) 192-71-20 <br />(495) 33-111-33</p>
                    <p class="footer__info-text-p SoyuzGrotesk">м. "Новые Черемушки", 117418, <br />Москва, ул. Зюзинская, 6, к.2</p>
                    <p class="footer__info-text-p SoyuzGrotesk">Понедельник - Пятница <br />10:00 - 18:00</p>
                </div>
                <div class="footer__info-socials">
                    <a href="https://web.whatsapp.com">
                        <img src="../src/img/wh.png" alt="wh" class="footer__info-socials-img" />
                    </a>
                    <a href="https://t.me/isnssd">
                        <img src="../src/img/tg.png" alt="tg" class="footer__info-socials-img" />
                    </a>
                    <a href="https://vk.com/isnssd">
                        <img src="../src/img/vk.png" alt="vk" class="footer__info-socials-img" />
                    </a>
                </div>
            </div>
        </div>
    </footer>
    <script type="module" src="/main.js"></script>
</body>
</html>