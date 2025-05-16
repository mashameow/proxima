<?php
// Подключение к БД
$conn = new mysqli('localhost', 'root', '', 'proxima');
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем списки услуг и продукции
$services = $conn->query("SELECT ID_servises, nameServises, price FROM servises");
$products = $conn->query("SELECT ID_products, nameProduct, price FROM products");

// Список количеств
$quantities = [50, 100, 200, 300, 400, 500, 1000];

$calculated = false;
$totalServicePrice = 0;
$totalProductPrice = 0;
$totalPrice = 0;

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $serviceId = (int)$_POST["service"];
    $productId = (int)$_POST["product"];
    $quantity = (int)$_POST["quantity"];

    // Получаем цены
    $serviceRes = $conn->query("SELECT price FROM servises WHERE ID_servises = $serviceId");
    $productRes = $conn->query("SELECT price FROM products WHERE ID_products = $productId");

    if ($serviceRes && $productRes && $serviceRes->num_rows > 0 && $productRes->num_rows > 0) {
        $servicePrice = $serviceRes->fetch_assoc()["price"];
        $productPrice = $productRes->fetch_assoc()["price"];

        $totalServicePrice = $servicePrice * $quantity;
        $totalProductPrice = $productPrice * $quantity;
        $totalPrice = $totalServicePrice + $totalProductPrice;
        $calculated = true;
    }
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
  <section class="heroCalculate">
    <div class="heroCalculate__container container">
        <h2 class="heroCalculate__title SoyuzGrotesk section-title">Калькулятор</h2>
        <p class="heroCalculate__text">Добро пожаловать в наш раздел с калькулятором услуг! Здесь вы можете быстро и удобно рассчитать стоимость необходимых вам услуг и продукции. Мы предлагаем различные варианты, и наш калькулятор поможет вам получить представление о цене в зависимости от ваших потребностей.</p>
        <div class="heroCalculate__block">
             <form class='heroCalculate__block-form' method="POST" >
                <div class="heroCalculate__block-form-input">
                    <label for="service">Услуга:</label>
                    <select class='heroCalculate__block-form-input-select' name="service" id="service" required>
                        <option  value="">Выберите услугу</option>
                        <?php while ($row = $services->fetch_assoc()): ?>
                            <option value="<?= $row['ID_servises'] ?>">
                                <?= htmlspecialchars($row['nameServises']) ?> 
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="heroCalculate__block-form-input">
                    <label for="product">Продукция:</label>
                    <select class='heroCalculate__block-form-input-select' name="product" id="product" required>
                        <option  value="">Выберите продукцию</option>
                        <?php while ($row = $products->fetch_assoc()): ?>
                            <option value="<?= $row['ID_products'] ?>">
                                <?= htmlspecialchars($row['nameProduct']) ?> 
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="heroCalculate__block-form-input">
                    <label for="quantity">Тираж:</label>
                    <select class='heroCalculate__block-form-input-select' name="quantity" id="quantity" required>
                        <option value="">Выберите тираж</option>
                        <?php foreach ($quantities as $qty): ?>
                            <option value="<?= $qty ?>"><?= $qty ?> шт</option>
                        <?php endforeach; ?>
                    </select>
                </div>
        <input class='heroCalculate__block-button button' type="submit" value="Рассчитать">
    </form>
    
    <?php if ($calculated): ?>
        <div class="heroCalculate__block-info">
            <p class="heroCalculate__block-info-text">Обратите внимание, что итоговая цена может варьироваться в зависимости от специфики вашего проекта. Если у вас возникли вопросы или вам нужна помощь, не стесняйтесь обращаться к нашей команде!</p>
            <p class="heroCalculate__block-info-title">Стоимость услуги: <?= $totalServicePrice ?> руб.</p>
            <p class="heroCalculate__block-info-title">Стоимость продукции: <?= $totalProductPrice ?> руб.</p>
            <p class="heroCalculate__block-info-title right">Итого: <?= $totalPrice ?> руб.</p>
        </div>
        <?php endif; ?>
    </div>
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
</body>
</html>
