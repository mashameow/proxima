<?php
session_start();
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
					<a href="../index.html">
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
							href="./page/contacts.html"
							class="header__nav-menu-link SoyuzGrotesk"
							>все о заказе</a
						>
						<a
							href="./page/help.html"
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
			<section class="aboutHero">
				<div class="aboutHero__container container">
					<h2 class="aboutHero__title SoyuzGrotesk section-title">
						Коротко о нас
					</h2>
					<div class="aboutHero__info">
						<div class="aboutHero__info-text">
							<p class="aboutHero__info-text-about">
								Компания  «Проксима»  занимает прочное место на рынке
								полиграфических услуг Москвы  с 1995 года.
							</p>
							<p class="aboutHero__info-text-about">
								Наша типография оказывает широкий спектр услуг оперативной
								полиграфии и прикладной рекламы. Кроме того, современное
								печатное оборудование компании обеспечивает высокое качество
								наших услуг. Вместе с этим, команда профессионалов нашей
								компании оставит довольным любого, самого взыскательного
								клиента.
							</p>
						</div>
						<img
							src="../src/img/typewriter.png"
							alt="typewriter"
							class="aboutHero__info-img"
						/>
					</div>
					<div class="aboutHero__info">
						<img
							src="../src/img/book.png"
							alt="book"
							class="aboutHero__info-img"
						/>
						<div class="aboutHero__info-text">
							<p class="aboutHero__info-text-about">
								Оформить заказ можно по телефону, WhatsApp, Telegram, соцсети
								или e-mail.
							</p>
							<p class="aboutHero__info-text-about">
								Благодаря такому подходу, клиенту не придется тратить свое 
								время на поездку в офис. Достаточно согласовать с менеджером
								детали заказа, произвести его подсчет и отправить в печать. По
								завершению работы, заказ упаковывается и максимально
								быстро доставляется в нужную точку Москвы.
							</p>
						</div>
					</div>
				</div>
			</section>
			<section class="advantages">
				<div class="advantages__container container">
					<h2 class="advantages__title SoyuzGrotesk section-title">
						наши преимущества
					</h2>
					<div class="advantages__block-cards">
						<div class="advantages__block-cards-card card">
							<div class="advantages__block-cards-card-icon card-icon">
								<img
									src="../src/icon/Clock.png"
									alt="Clock"
									class="advantages__block-cards-card-icon-img card-icon-img"
								/>
							</div>
							<div class="advantages__block-cards-card-text card-text">
								<p
									class="advantages__block-cards-card-text-title card-text-title"
								>
									Опыт с 1991 года
								</p>
								<p
									class="advantages__block-cards-card-text-comment card-text-comment"
								>
									Позволяющий плодотворно работать как с крупными прямыми
									клиентами и рекламными агентствами, так и с теми, чьи
									потребности в полиграфии ограничиваются небольшими тиражами.
								</p>
							</div>
						</div>
						<div class="advantages__block-cards-card card">
							<div class="advantages__block-cards-card-icon card-icon">
								<img
									src="../src/icon/Heart.png"
									alt="Heart"
									class="advantages__block-cards-card-icon-img card-icon-img"
								/>
							</div>
							<div class="advantages__block-cards-card-text card-text">
								<p
									class="advantages__block-cards-card-text-title card-text-title"
								>
									Отношение к клиенту
								</p>
								<p
									class="advantages__block-cards-card-text-comment card-text-comment"
								>
									Которое экономит его время и деньги, позволяет нам работать
									без 100% предоплаты и с оплатой по факту. Индивидуальный
									подход к каждому клиенту — наш принцип.
								</p>
							</div>
						</div>
						<div class="advantages__block-cards-card card">
							<div class="advantages__block-cards-card-icon card-icon">
								<img
									src="../src/icon/People.png"
									alt="People"
									class="advantages__block-cards-card-icon-img card-icon-img"
								/>
							</div>
							<div class="advantages__block-cards-card-text card-text">
								<p
									class="advantages__block-cards-card-text-title card-text-title"
								>
									опытные сотрудники
								</p>
								<p
									class="advantages__block-cards-card-text-comment card-text-comment"
								>
									Которые работают давно, много и профессионально, отвечают за
									свою работу и умеют ее планировать, ценят и умеют
									поддерживать хорошие отношения с клиентами.
								</p>
							</div>
						</div>
						<div class="advantages__block-cards-card card">
							<div class="advantages__block-cards-card-icon card-icon">
								<img
									src="../src/icon/Exterior.png"
									alt="Exterior"
									class="advantages__block-cards-card-icon-img card-icon-img"
								/>
							</div>
							<div class="advantages__block-cards-card-text card-text">
								<p
									class="advantages__block-cards-card-text-title card-text-title"
								>
									Свое производство
								</p>
								<p
									class="advantages__block-cards-card-text-comment card-text-comment"
								>
									Оптимизированое и отлаженное под нужды оперативной полиграфии,
									использующее расходные и технологические материалы только
									ведущих мировых производителей.
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>
			<section class="purpose">
				<div class="purpose__container container">
					<p class="purpose__text">
						Мы отвергаем пафос и никогда не стремились стать очень большой
						типографией. Во главе стратегии нашего развития всегда были простые
						принципы и цели:
					</p>
					<div class="purpose__block">
						<p class="purpose__block-number">1.</p>
						<p class="purpose__block-text">
							Hазвиваться шаг за шагом накапливая самое бесценное - опыт работы,
							собирая профессиональный персонал и сосредотачивая в собственных
							руках максимум возможностей
						</p>
					</div>
					<div class="purpose__block">
						<p class="purpose__block-number">2.</p>
						<p class="purpose__block-text">
							Оптимально отладить под нужды клиентов наши производственные и
							плановые процессы
						</p>
					</div>
					<div class="purpose__block">
						<p class="purpose__block-number">3.</p>
						<p class="purpose__block-text">
							Самое важное - научиться выстраивать с клиентом партнерские и
							доверительные отношения, которыми мы нескромно гордимся
						</p>
					</div>
				</div>
			</section>
			<section class="partnersAbout">
				<div class="partnersAbout__container container">
					<h2 class="partnersAbout__title SoyuzGrotesk section-title">
						наши клиенты и партнеры
					</h2>
					<p class="partnersAbout__text">
						Спасибо клиентам, с которыми работаем давно
					</p>
					<div class="partnersAbout__block"></div>
					<button class="button partnersAbout__button">показать еще</button>
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
							<RouterLink
								to="/all-about-order"
								class="order__info-text-link SoyuzGrotesk"
								>все о заказе</RouterLink
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
			<section class="questions">
				<form
					method="post"
					action="../src/php/questions.php"
					class="questions__container container"
				>
					<h2 class="questions__title SoyuzGrotesk section-title">
						Появились вопросы?
					</h2>
					<p class="questions__text">Мы ответим в течение часа</p>
					<div class="questions__info">
						<div class="questions__info-inpus">
							<input
								type="text"
								name="name"
								placeholder="Имя"
								class="questions__info-inpus-input input"
								 value="<?php echo isset($_SESSION['user__name']) ? htmlspecialchars($_SESSION['user__name']) : ''; ?>"
								required
							/>
							<input
								type="email"
								name="email"
								placeholder="Email"
								class="questions__info-inpus-input input"
								 value="<?php echo isset($_SESSION['auth__email']) ? htmlspecialchars($_SESSION['auth__email']) : ''; ?>"
								required
							/>
							<input
								type="text"
								name="phone"
								placeholder="Телефон"
								class="questions__info-inpus-input input"
								 value="<?php echo isset($_SESSION['user__phone']) ? htmlspecialchars($_SESSION['user__phone']) : ''; ?>"
								required
							/>
						</div>
						<textarea
							name="question"
							id="questions__info-textarea"
							placeholder="Что вас интересует?"
							class="questions__info-textarea input"
							required
						></textarea>
					</div>
					<div class="questions__btn-container">
						<button
							type="submit"
							class="button pink hero__info-button questions__btn"
						>
							Задать вопрос
						</button>
					</div>
				</form>
			</section>
		</main>
		<footer class="footer">
			<div class="footer__container">
				<nav class="nav">
					<a href="../index.html">
						<img
							src="../src/img/logo2.png"
							alt="logo"
							class="footer__nav-img"
						/>
					</a>
					<ul class="footer__nav-menu">
						<a href="./about.html" class="footer__nav-menu-link SoyuzGrotesk"
							>о нас</a
						>
						<a href="./servises.php" class="footer__nav-menu-link SoyuzGrotesk"
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

					<a href="/account" class="footer__nav-account SoyuzGrotesk"
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
