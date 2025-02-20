<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');
$product_id = $_GET['id'];
$_SESSION['product_id'] = $product_id;

// Проверка на ошибки подключения к базе данных
if ($db == false) {
    echo "<script>alert('Ошибка подключения к базе данных');</script>";
    exit(); // Прекращаем выполнение скрипта, так как база недоступна
}

// Получаем данные о продукте из базы данных
$product_stmt = $db->prepare("SELECT * FROM products WHERE ID_products = ?");
$product_stmt->bind_param("i", $product_id);
$product_stmt->execute();
$product_result = $product_stmt->get_result();

if ($product_result->num_rows > 0) {
    $product_data = $product_result->fetch_assoc();

    $_SESSION['nameProduct'] = $product_data['nameProduct'];
    $_SESSION['description'] = $product_data['description'];
    $_SESSION['specifications'] = $product_data['specifications'];
    $_SESSION['image'] = $product_data['image'];
    $_SESSION['icon'] = $product_data['icon'];
} else {
    echo "<script>alert('Продукт не найден'); history.go(-1);</script>";
    exit(); // Прекращаем выполнение скрипта, так как продукт не найден
}

// Закрываем соединение с базой данных
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../style.css" />
    <title><?php echo $_SESSION['nameProduct']; ?></title>
</head>

<body>
    <header class="header">
        <div class="header__container">
            <nav class="nav">
                <a href="../index.html">
                    <img src="../src/img/logo2.png" alt="logo" class="header__nav-img" />
                </a>
                <ul class="header__nav-menu">
                    <a href="./about.html" class="header__nav-menu-link SoyuzGrotesk">о нас</a>
                    <a href="./servises.php" class="header__nav-menu-link SoyuzGrotesk">услуги</a>
                    <a href="./page/contacts.html" class="header__nav-menu-link SoyuzGrotesk">все о заказе</a>
                    <a href="./page/help.html" class="header__nav-menu-link SoyuzGrotesk">контакты</a>
                </ul>
                <a href="./account.php" class="header__nav-account SoyuzGrotesk">Личный кабинет</a>
            </nav>
        </div>
    </header>
    <main>
        <section class="heroSelectedProduct">
            <div class="heroSelectedProduct__container container">
                <div class="heroSelectedProduct__info">
                    <div class="heroSelectedProduct__info-text">
                        <h2 class="heroSelectedProduct__title SoyuzGrotesk section-title"><?php echo $_SESSION['nameProduct']; ?></h2>
                        <p class="heroSelectedProduct__description"><?php echo $_SESSION['description']; ?></p>
                        <h3 class="heroSelectedProduct__text SoyuzGrotesk section-title">Основные характеристики:</h3>
                        <p class="heroSelectedProduct__specifications"><?php echo $_SESSION['specifications']; ?></p>
                    </div>
                    <div class="heroSelectedProduct__info-image">
                        <img src="../src/img/products/<?php echo $_SESSION['image']; ?>" alt="<?php echo $_SESSION['nameProduct']; ?>" />
                    </div>
                </div>
                <div class="heroSelectedProduct__exit exit-block">
                    <button class="heroSelectedProduct__exit-btn exit button" onclick="history.back();">назад</button>
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
                    <a href="./page/contacts.html" class="button">подробнее</a>
                </div>
                <img src="../src/img/megaphone.png" alt="megaphone" class="order__img" />
            </div>
        </section>
    </main>
    <footer class="footer">
        <div class="footer__container">
            <nav class="nav">
                <a href="../index.html">
                    <img src="../src/img/logo2.png" alt="logo" class="footer__nav-img" />
                </a>
                <ul class="footer__nav-menu">
                    <a href="./about.html" class="footer__nav-menu-link SoyuzGrotesk">о нас</a>
                    <a href="./servises.php" class="footer__nav-menu-link SoyuzGrotesk">услуги</a>
                    <a href="./page/contacts.html" class="footer__nav-menu-link SoyuzGrotesk">все о заказе</a>
                    <a href="./page/help.html" class="footer__nav-menu-link SoyuzGrotesk">контакты</a>
                </ul>
                <a href="./account.php" class="footer__nav-account SoyuzGrotesk">Личный кабинет</a>
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