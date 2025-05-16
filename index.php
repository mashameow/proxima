<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');

// Проверка соединения
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}


// Выполнение SQL-запроса для получения первых 6 продуктов
$sql = "SELECT ID_products, nameProduct, description, specifications, image, icon FROM products LIMIT 6";
$resultProd = mysqli_query($db, $sql);

// Закрытие соединения с базой данных
mysqli_close($db);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="./style.css" />
		<title>проксима</title>
	</head>
	<body>
		
		<header class="header">
			<div class="header__container">
				<nav class="nav">
					<a href="#">
						<img src="./src/img/logo2.png" alt="logo" class="header__nav-img" />
					</a>
					<ul class="header__nav-menu">
						<a
							href="./pages/about.php"
							class="header__nav-menu-link SoyuzGrotesk"
							>о нас</a
						>
						<a
							href="./pages/servises.php"
							class="header__nav-menu-link SoyuzGrotesk"
							>услуги</a
						>
						<a
							href="./pages/aboutOrder.php"
							class="header__nav-menu-link SoyuzGrotesk"
							>все о заказе</a
						>
						<a
							href="./pages/contacts.html"
							class="header__nav-menu-link SoyuzGrotesk"
							>контакты</a
						>
					</ul>

					<a href="./pages/account.php" class="header__nav-account SoyuzGrotesk"
						>Личный кабинет</a
					>
				</nav>
			</div>
		</header>
		<main>
			<section class="hero">
				<div class="hero__container container">
					<div class="hero__info">
						<h1 class="hero__info-title">Проксима типография</h1>
						<p class="hero__info-text">ближе, чем кажется</p>
						<p class="hero__info-p">
							Выполним от дизайна до доставки. Полный комплекс профессиональных
							услуг в области оперативной полиграфии и тиражирования, а также
							производство сувенирной продукции…
						</p>
						<a href="./pages/about.php" class="button hero__info-button"
							>подробнее о нас</a
						>
					</div>
					<img
						src="./src/img/background.png"
						alt="background"
						class="hero__background"
					/>
				</div>
			</section>
			<section class="partners">
				<div class="partners__container container">
					<h2 class="partners__title SoyuzGrotesk section-title">
						наши клиенты и партнеры
					</h2>
					<div class="partners__block">
						<div class="partners__block-left">
							<img
								src="./src/img/people.png"
								alt="people"
								class="partners__block-left-img"
							/>
							<a href="./pages/about.php" class="button hero__info-button"
								>подробнее</a
							>
						</div>
						<div class="partners__block-info">
							<p class="partners__block-info-text">
								Спасибо клиентам, с которыми работаем давно
							</p>
							<div id="logos" data-limit="12" class="partnersAbout__block partners__block-info-images"></div>
						</div>
					</div>
				</div>
			</section>
			<section class="services">
				<div class="services__container container">
					<h2 class="services__title SoyuzGrotesk section-title">
						Полный комплекс услуг
					</h2>
					<div class="services__block">
						<div class="services__block-info">
							<div class="services__block-info-row">
								<img
									src="./src/icon/PC.png"
									alt="PC"
									class="services__block-info-icon"
								/>
								<p class="services__block-info-text">
									Профессиональный дизайн и подготовка предпечатных материалов
								</p>
							</div>
							<div class="services__block-info-row">
								<img
									src="./src/icon/Printer.png"
									alt="Printer"
									class="services__block-info-icon"
								/>
								<p class="services__block-info-text">
									Ризография, шелкотрафарет, тиснение, термопечать
								</p>
							</div>
							<div class="services__block-info-row">
								<img
									src="./src/icon/Blog.png"
									alt="Blog"
									class="services__block-info-icon"
								/>
								<p class="services__block-info-text">
									Офсетное и цифровое тиражирование
								</p>
							</div>
							<div class="services__block-info-row">
								<img
									src="./src/icon/Documents.png"
									alt="Documents"
									class="services__block-info-icon"
								/>
								<p class="services__block-info-text">
									Разнообразная финишная отделка тиражей
								</p>
							</div>
							<div class="services__block-info-row">
								<img
									src="./src/icon/Refresh.png"
									alt="Refresh"
									class="services__block-info-icon"
								/>
								<p class="services__block-info-text">
									Корпоративное обслуживание клиентов
								</p>
							</div>
							<p class="services__block-info-text">
								Кстати, мы работаем с 1991 года
							</p>
						</div>
						<div class="services__block-image">
							<img
								src="./src/img/hand.png"
								alt="hand"
								class="services__block-image-img"
							/>
							<a href="./pages/servises.php" class="button hero__info-button"
								>подробнее об услугах</a
							>
						</div>
					</div>
				</div>
			</section>
			<section class="products">
				<div class="products__container container">
					<h2 class="products__title SoyuzGrotesk section-title">Продукция</h2>
					<p class="products__text">
						Типография Проксима - помогаем выглядеть достойно
					</p>
					<div class="products__block">
						<div class="products__block-cards">
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
						<a href="./pages/servises.php" class="button hero__info-button hero__info-button-servises"
							>наша продукция</a
						>
					</div>
				</div>
			</section>
			<?php
			// Включаем файл с формой
			include './src/php/upload_form/upload_form.php';
			?>
			<?php
			// Включаем файл с формой
			include './src/php/calculate_form/calcilate_form.php';
			?>
			<?php
			// Включаем файл с формой
			include './src/php/question_form/question_form.php';
			?>
			<section class="mailing">
				<div class="mailing__container container">
					<h2 class="mailing__title SoyuzGrotesk section-title">
						узнавайте новости первыми
					</h2>
					<p class="mailing__text">
						Подпишитесь на нашу почтовую рассылку и первыми узнавайте о горячих
						предложениях, акциях и других новостях:)
					</p>
					<div class="mailing__info">
						<input
							type="text"
							placeholder="Email"
							class="mailing__info-input input"
						/><a href="" class="button green hero__info-button mailing__btn"
							>Подписаться</a
						>
					</div>
				</div>
			</section>
		</main>
		<footer class="footer">
			<div class="footer__container">
				<nav class="nav">
					<a href="#">
						<img src="./src/img/logo2.png" alt="logo" class="footer__nav-img" />
					</a>
					<ul class="footer__nav-menu">
						<a
							href="./page/about.php"
							class="footer__nav-menu-link SoyuzGrotesk"
							>о нас</a
						>
						<a href="./page/FAQ.html" class="footer__nav-menu-link SoyuzGrotesk"
							>услуги</a
						>
						<a
							href="./page/contacts.html"
							class="footer__nav-menu-link SoyuzGrotesk"
							>все о заказе</a
						>
						<a
							href="./page/help.html"
							class="footer__nav-menu-link SoyuzGrotesk"
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
								src="./src/img/wh.png"
								alt="wh"
								class="footer__info-socials-img"
							/> </a
						><a href="https://t.me/isnssd">
							<img
								src="./src/img/tg.png"
								alt="tg"
								class="footer__info-socials-img"
							/> </a
						><a href="https://vk.com/isnssd">
							<img
								src="./src/img/vk.png"
								alt="vk"
								class="footer__info-socials-img"
							/>
						</a>
					</div>
				</div>
			</div>
		</footer>
		<script type="module" src="/main.js"></script>
		<script type="module" src="./src/js/api_client_logos.js"></script>
	</body>
</html>
