<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');

// Проверка соединения
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Выполнение SQL-запроса для получения всех услуг
$sql = "SELECT ID_servises, nameServises, description, features, products FROM servises";
$resultServ = mysqli_query($db, $sql);


// Выполнение SQL-запроса для получения всех продуктов
$sql = "SELECT ID_products, nameProduct, description, specifications, image, icon FROM products";
$resultProd = mysqli_query($db, $sql);

 

// Закрытие соединения с базой данных
mysqli_close($db);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../style.css" />

		<title>проксима</title>
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
			<section class="heroServises">
				<div class="heroServises__container container">
					<h2 class="heroServises__title SoyuzGrotesk section-title">
						Аналитика услуг прошлого года
					</h2>
					<div class="heroServises__info">
						<div class="heroServises__info-chart">
							<div class="heroServises__info-chart-text">
								<p class="heroServises__info-chart-text-info">
									Офсетная печать
								</p>
								<p class="heroServises__info-chart-text-number">100%</p>
							</div>
							<div class="heroServises__info-chart-line"></div>
							<div class="heroServises__info-chart-text">
								<p class="heroServises__info-chart-text-info">Ризография</p>
								<p class="heroServises__info-chart-text-number">95%</p>
							</div>
							<div class="heroServises__info-chart-line line2"></div>
							<div class="heroServises__info-chart-text">
								<p class="heroServises__info-chart-text-info">
									Дизайн и верстка
								</p>
								<p class="heroServises__info-chart-text-number">90%</p>
							</div>
							<div class="heroServises__info-chart-line line3"></div>
							<div class="heroServises__info-chart-text">
								<p class="heroServises__info-chart-text-info">
									Цифровая печать
								</p>
								<p class="heroServises__info-chart-text-number">75%</p>
							</div>
							<div class="heroServises__info-chart-line line4"></div>
						</div>
						<img
							src="../src/img/businessman.png"
							alt="businessman"
							class="heroServises__info-img"
						/>
					</div>
					<p class="heroServises__text">
						В процентном соотношении указан уровень загрузки оборудования или
						услуги в рабочие часы типографии.
					</p>
				</div>
			</section>
			<section class="ourServises">
				<div class="ourServises__container container">
					<h2 class="ourServises__title SoyuzGrotesk section-title">
						наши услуги
					</h2>
					<div class="ourServises__info">
						<div class="ourServises__info-cards">
						<?php
						if (mysqli_num_rows($resultServ) > 0) {
							// Цикл для перебора всех услуг
							while ($service = mysqli_fetch_assoc($resultServ)) {
								?>
								<a href="./selectedService.php?id=<?= $service['ID_servises'] ?>" class="ourServises__info-cards-card ourServises__info-cards-card-text-title">
									<div class="ourServises__info-cards-card-icon">
										<p class="ourServises__info-cards-card-icon-number"><?= $service['ID_servises'] ?>.</p>
									</div>
									<?= htmlspecialchars($service['nameServises']) ?>
								</a>
								<?php
							}
						} else {
							echo "Нет доступных услуг.";
						}
						?>
							
						</div>
						<img
							src="../src/img/handPen.svg"
							alt="handPen"
							class="ourServises__info-img"
						/>
					</div>
				</div>
			</section>
			<section class="analytics">
				<div class="analytics__container container">
					<h2 class="analytics__title SoyuzGrotesk section-title">
						Аналитика продукции прошлого года
					</h2>
					<div class="analytics__info">
						<div class="analytics__info-circle">
							<img
								src="../src/img/1.svg"
								alt=""
								class="analytics__info-circle-img"
							/><img
								src="../src/img/5.svg"
								alt=""
								class="analytics__info-circle-img"
							/><img
								src="../src/img/6.svg"
								alt=""
								class="analytics__info-circle-img"
							/><img
								src="../src/img/7.svg"
								alt=""
								class="analytics__info-circle-img"
							/>
						</div>
						<p class="analytics__info-comment">
							В процентном соотношении указан уровень загрузки оборудования или
							услуги в рабочие часы типографии.
						</p>
					</div>
				</div>
			</section>
			<section class="ourProducts">
				<div class="ourProducts__container container">
					<h2 class="ourProducts__title SoyuzGrotesk section-title">
						наша продукция
					</h2>
					<div class="ourProducts__cards">
						<?php
						// Проверка, есть ли результаты
						if (mysqli_num_rows($resultProd) > 0) {
    						// Цикл для перебора всех продуктов
    						while ($product = mysqli_fetch_assoc($resultProd)) {
        						?>
        						<a href='./selectedProduct.php?id=<?= $product['ID_products'] ?>' class="ourProducts__cards-card ourProducts__cards-card-text-title">
            						<div class="ourProducts__cards-card-icon">
                						<img
                    						src="../src/icon/products/<?php echo htmlspecialchars($product['icon']); ?>"
                    						alt="<?php echo htmlspecialchars($product['nameProduct']); ?>"
                    						class="ourProducts__cards-card-icon-img"
                						/>
            						</div>
            						<?php echo htmlspecialchars($product['nameProduct']); ?>
        						</a>
        						<?php
    						}
						}
						?>
						
					</div>
				</div>
			</section>
			<section class="order">
				<div class="order__container container">
					<div class="order__info">
						<h2 class="order__info-title SoyuzGrotesk section-title">
							Хотите оформить заказ?
						</h2>
						<p class="order__info-text">
							Мы рады приветствовать вас на сайте нашей типографии! <br />
							Для вашего удобства мы подготовили раздел
							<a href="#" class="order__info-text-link SoyuzGrotesk"
								>все о заказе</a
							>, где вы сможете найти всю необходимую информацию о том, как
							оформить заказ и пройти все его этапы.
						</p>
						<a href="" class="button">подробнее</a>
					</div>
					<img
						src="../src/img/megaphone.png"
						alt="megaphone"
						class="order__img"
					/>
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
						<p class="footer__info-text-p SoyuzGrotesk">
							(903) 192-71-20 <br />(495) 33-111-33
						</p>
						<p class="footer__info-text-p SoyuzGrotesk">
							м. "Новые Черемушки", 117418, <br />Москва, ул. Зюзинская, 6, к.2
						</p>
						<p class="footer__info-text-p SoyuzGrotesk">
							Понедельник - Пятница <br />10:00 - 18:00
						</p>
					</div>
					<div class="footer__info-socials">
						<a href="https://web.whatsapp.com">
							<img
								src="../src/img/wh.png"
								alt="wh"
								class="footer__info-socials-img"
							/> </a
						><a href="https://t.me/isnssd">
							<img
								src="../src/img/tg.png"
								alt="tg"
								class="footer__info-socials-img"
							/> </a
						><a href="https://vk.com/isnssd">
							<img
								src="../src/img/vk.png"
								alt="vk"
								class="footer__info-socials-img"
							/>
						</a>
					</div>
				</div>
			</div>
		</footer>
		<script type="module" src="/main.js"></script>
	</body>
</html>
