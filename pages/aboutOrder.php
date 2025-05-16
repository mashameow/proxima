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
						<a href="./contacts.html" class="header__nav-menu-link SoyuzGrotesk"
							>контакты</a
						>
					</ul>

					<a href="./account.php" class="header__nav-account SoyuzGrotesk"
						>Личный кабинет</a
					>
				</nav>
			</div>
		</header>
		<section class="heroAboutOrder">
			<div class="heroAboutOrder__container container">
				<h2 class="heroAboutOrder__title SoyuzGrotesk section-title">
					Оформить заказ - как это сделать?
				</h2>
				<div class="heroAboutOrder__block">
					<div class="heroAboutOrder__block-info">
						<div
							class="heroAboutOrder__block-info-text AboutOrder__block-info-text1"
						>
							<p class="heroAboutOrder__block-info-text-name">1. Обращение</p>
							<p class="heroAboutOrder__block-info-text-comment">
								Процесс работы с заказом начинается с момента Вашего обращения к
								нам с целью выяснения возможности, условий и стоимости
								исполнения интересующей Вас продукции.
							</p>
						</div>
						<div
							class="heroAboutOrder__block-info-text AboutOrder__block-info-text2"
						>
							<p class="heroAboutOrder__block-info-text-name">3. Поддержка</p>
							<p class="heroAboutOrder__block-info-text-comment">
								Даже если Вы совсем не знакомы со спецификой полиграфического
								производства, наши менеджеры с радостью помогут Вам составить
								профессиональный, а также технологический портрет Вашего заказа.
							</p>
						</div>
					</div>
					<div
						class="heroAboutOrder__block-info-text AboutOrder__block-info-text3"
					>
						<p class="heroAboutOrder__block-info-text-name">2. Важно!</p>
						<p class="heroAboutOrder__block-info-text-comment">
							Обязательно предоставьте менеджеру свои пожелания и максимально
							точные характеристики планируемой продукции, включая детали, такие
							как размеры и цвет, чтобы гарантировать соответствие вашим
							ожиданиям. Для более четкого понимания объема предстоящих работ
							следует описать желаемые материалы (тип, формат, количество,
							другие характеристики) и их назначение.
						</p>
					</div>
				</div>
			</div>
		</section>
		
		<?php
			// Включаем файл с формой
			include '../src/php/order_form/order_form.php';
		?>
		<section class="importantAboutOrder">
			<div class="importantAboutOrder__container container">
				<h2 class="importantAboutOrder__title SoyuzGrotesk section-title">
					важные ньюансы
				</h2>
				<div class="importantAboutOrder__block">
					<div class="importantAboutOrder__block-header">
						<p class="importantAboutOrder__block-header-title">
							Предварительный расчет
						</p>
						<div class="importantAboutOrder__block-header-button">
							<img
								src="../src/icon/Plus.png"
								alt="Plus"
								class="importantAboutOrder__block-header-img"
							/>
						</div>
					</div>
					<div class="importantAboutOrder__block-info" hidden>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Исходя из полученных в ходе оформления заказа характеристик и
							вариантов тиражных данных необходимой продукции, составляются
							варианты предварительного расчета.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							До момента подписания технологического листа заказа его
							характеристики могут быть изменены по желанию клиента или уточнены
							в ходе возможных согласований, что может повлиять на окончательную
							стоимость продукции.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Стоимость любой продукции складывается из стоимости дизайна,
							предпечатной подготовки, печатных работ, послепечатной отделки и
							стоимости используемых при изготовлении продукции материалов.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Следует учесть, что определенное влияние на стоимость некоторых
							работ может оказать сложность макета, оценить которую при
							телефонном согласовании не представляется возможным. При прочих
							равных характеристиках стоимость тиража буклета, содержащего
							текст, некоторое количество фотографий или простых элементов
							графического оформления, будет меньше, чем буклета, в оформлении
							которого использовано большое количество насыщенных фоновых
							заливок или pantone-цветов вместо стандартных триадных красок.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Таким образом окончательный вердикт по стоимости возможен только
							при наличии подробного описания продукции и ее макета.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							При наличии в составе работ дизайна и верстки, окончательная
							стоимость, в некоторых случаях, может быть определена только на
							момент готовности окончательного макета. Естественно стоимость
							единицы таких работ, например сканирования одного слайда и верстки
							одной полосы, согласовывается с клиентом заранее, а окончательная
							стоимость тиражных работ в таком случае зависит от характеристик
							полученного макета. Поэтому нормой считается ситуация, когда при
							приеме заказа на подготовку и тиражированиемногостраничной
							продукции составляется предварительная смета с согласованными
							расценками за отдельные этапы работ и их возможным объемом.
						</p>
					</div>
				</div>
				<div class="importantAboutOrder__block">
					<div class="importantAboutOrder__block-header">
						<p class="importantAboutOrder__block-header-title">
							Окончательный расчет
						</p>
						<div class="importantAboutOrder__block-header-button">
							<img
								src="../src/icon/Plus.png"
								alt="Plus"
								class="importantAboutOrder__block-header-img"
							/>
						</div>
					</div>
					<div class="importantAboutOrder__block-info" hidden>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Окончательная стоимость заказа формируется на момент оформления
							подробной технологической карты заказа, платежных документов и его
							постановки в рабочий план.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Мы не заинтересованы в том, чтобы значения предварительного и
							окончательного расчетов существенно различались. Поэтому
							прикладываем все усилия для изначально подробного описания
							технологического портрета заказа и просим клиентов по возможности
							твердо определиться с параметрами, изменение которых может оказать
							существенное влияние на эту разницу (вид материалов, сложность
							макета, размеры клише).
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Часто у клиентов возникает вопрос, почему стоимость единицы
							полиграфической продукции при прочих одинаковых характеристиках не
							равная на различных тиражах?
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Этот факт объясняется высокими стартовыми технологическими
							затратами полиграфического производства, которые независимо от
							того, нужен Вам один лист или тысяча, в обоих случаях составляют
							одну и ту же сумму. Формально, стоимость производства одного листа
							может не существенно отличаться от стоимости сотни. С увеличением
							тиража эта картина меняется в сторону падения цен за экземпляр
							продукции за счет разнесения стартовых затрат на стоимость
							отдельных экземпляров.
						</p>
					</div>
				</div>
				<div class="importantAboutOrder__block">
					<div class="importantAboutOrder__block-header">
						<p class="importantAboutOrder__block-header-title">
							Сроки исполнения
						</p>
						<div class="importantAboutOrder__block-header-button">
							<img
								src="../src/icon/Plus.png"
								alt="Plus"
								class="importantAboutOrder__block-header-img"
							/>
						</div>
					</div>
					<div class="importantAboutOrder__block-info" hidden>
						<p for="input1" class="importantAboutOrder__block-info-text">
							На момент Вашего обращения в приемную фирмы исходя из
							характеристик Вашего заказа и информации о состоянии уже
							существующего плана загрузки производства наши менеджеры могут
							указать ближайшую возможную дату исполнения Вашего заказа или
							оценить возможность исполнения заказа к желаемому для Вас времени.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Естественно, что в случае отсрочки принятия клиентом
							окончательного решения о размещении заказа на какое-то время
							состояние плана может измениться.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Поэтому обязательства по срокам исполнения тиража подтверждаются
							на момент оформления заказа и принятия клиентом на себя
							обязательств по его оплате.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Особый случай составляют заказы, содержащие в составе работ
							создание дизайна и верстку макетов продукции с их последующим
							утверждением. В данной ситуации возможны два варианта определения
							сроков исполнения заказов: с расчетом сроков на момент утверждения
							окончательного макета или к определенной заранее дате с
							согласованием графика исполнения работ, в ходе которых обе стороны
							обязуются придерживаться обязательств, связанных со сроками
							исполнения промежуточных и подготовительных работ, своевременной
							передачей материалов, выбором и утверждением вариантов дизайна и
							т.д.
						</p>
					</div>
				</div>
				<div class="importantAboutOrder__block">
					<div class="importantAboutOrder__block-header">
						<p class="importantAboutOrder__block-header-title">Ваш менеджер</p>
						<div class="importantAboutOrder__block-header-button">
							<img
								src="../src/icon/Plus.png"
								alt="Plus"
								class="importantAboutOrder__block-header-img"
							/>
						</div>
					</div>
					<div class="importantAboutOrder__block-info" hidden>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Обсчет, прием и сопровождение заказов на нашей фирме ведут
							менеджеры приемной. Естественно, что в процессе работы по
							согласованию заказов между Вами и работающим с Вами менеджером
							складывается определенный стиль рабочего общения, менять который,
							переходя на общение с другим менеджером, может оказаться
							нежелательным.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Однако ввиду того, что полиграфические заказы и заказы по
							производству сувенирной продукции ведут и планируют разные
							менеджеры, мы просим Вас с пониманием отнестись к тому, что по
							заказам на соответствующую продукцию с Вами будут общаться разные
							менеджеры.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Это оправданно с точки зрения технологии и процессов,
							обеспечивающих максимальное качество и соответствие продукции
							Вашим запросам.
						</p>
					</div>
				</div>
				<div class="importantAboutOrder__block">
					<div class="importantAboutOrder__block-header">
						<p class="importantAboutOrder__block-header-title">
							Материалы клиента
						</p>
						<div class="importantAboutOrder__block-header-button">
							<img
								src="../src/icon/Plus.png"
								alt="Plus"
								class="importantAboutOrder__block-header-img"
							/>
						</div>
					</div>
					<div class="importantAboutOrder__block-info" hidden>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Все рабочие материалы (слайды, фотографии, распечатки и т.п.) и
							носители информации, переданные заказчиком в процессе подготовки
							дизайна и верстки, возвращаются ему на момент подписания накладных
							о приеме продукции вместе с готовым тиражом.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Мы, храним пленки с отпечатанных заказов в течение полугода. При
							желании Вы можете забрать их вместе с готовым заказом. В последнем
							случае вопрос, хранить их на случай возникновения необходимости
							повторного тиража или оплачивать еще один комплект пленок Вам
							придется решать самим.
						</p>
						<p for="input1" class="importantAboutOrder__block-info-text">
							Не востребованные в течение месяца после сдачи продукции материалы
							обратно не возвращаются.
						</p>
					</div>
				</div>
			</div>
		</section>
		<?php
			// Включаем файл с формой
			include '../src/php/upload_form/upload_form.php';
		?>
		<?php
			// Включаем файл с формой
			include '../src/php/calculate_form/calcilate_form.php';
		?>
		<?php
			// Включаем файл с формой
			include '../src/php/question_form/question_form.php';
		?>
		<footer class="footer">
			<div class="footer__container">
				<nav class="nav">
					<a href="../index.php">
						<img
							src="../src/img/logo2.png"
							alt="logo"
							class="footer__nav-img"
						/>
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
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const blocks = document.querySelectorAll('.importantAboutOrder__block')

				blocks.forEach(block => {
					const toggleButton = block.querySelector(
						'.importantAboutOrder__block-header-button'
					)
					const content = block.querySelector(
						'.importantAboutOrder__block-info'
					)
					const icon = block.querySelector(
						'.importantAboutOrder__block-header-img'
					)

					toggleButton.addEventListener('click', () => {
						const isHidden = content.hasAttribute('hidden')

						// Скрываем все блоки, если нужно поведение "только один открыт"
						blocks.forEach(otherBlock => {
							const otherContent = otherBlock.querySelector(
								'.importantAboutOrder__block-info'
							)
							const otherIcon = otherBlock.querySelector(
								'.importantAboutOrder__block-header-img'
							)
							if (otherContent !== content) {
								otherContent.setAttribute('hidden', '')
								otherIcon.style.transform = 'rotate(0deg)' // Возвращаем "плюс" в исходное положение
							}
						})

						// Переключаем текущий блок
						if (isHidden) {
							content.removeAttribute('hidden')
							icon.style.transform = 'rotate(45deg)' // Повернуть "плюс" в "крестик"
						} else {
							content.setAttribute('hidden', '')
							icon.style.transform = 'rotate(0deg)' // Возвращаем "плюс" в исходное положение
						}
					})
				})
			})
		</script>

		<script type="module" src="/main.js"></script>
	</body>
</html>
