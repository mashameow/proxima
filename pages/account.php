<?php
session_start();
// Устанавливаем лимит времени сессии (в секундах)
$session_timeout = 3600; // 1 час
// Проверяем, установлено ли время последней активности
if (isset($_SESSION['last_activity'])) {
    // Проверяем, прошло ли время с последней активности
    if (time() - $_SESSION['last_activity'] > $session_timeout) {
        // Если прошло больше часа, уничтожаем сессию
        session_unset(); // Удаляем все переменные сессии
        session_destroy(); // Уничтожаем сессию
        header("Location: ../index.php"); // Перенаправляем на главную страницу
        exit();
    }
}
// Обновляем время последней активности
$_SESSION['last_activity'] = time();

if ($_POST) {
    // Авторизация пользователя
    if (isset($_POST['auth__email']) && isset($_POST['auth__pass']) && isset($_POST['g-recaptcha-response'])) {
        $email = $_POST['auth__email'];
        $password = $_POST['auth__pass'];
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // Проверка reCAPTCHA с использованием cURL
        $secret_key = '6LcPs_kpAAAAAH0g09WysybknpxhIZUeo7_9dJmJ';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => $secret_key,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $verify_response = curl_exec($ch);
        curl_close($ch);
        $response_data = json_decode($verify_response, true);

        if ($response_data['success']) {
            $db = mysqli_connect('localhost', 'root', '', 'proxima');
            // Подготовка запроса для получения пользователя по email
            $stmt = $db->prepare("SELECT ID_users, name, phone, role, password FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Проверка пароля с использованием хеширования
                if (password_verify($password, $user['password'])) {
                    $_SESSION['auth__email'] = $email;
                    $_SESSION['auth__pass'] = $password;
                    $_SESSION['user__name'] = $user['name'];
                    $_SESSION['user__phone'] = $user['phone'];
                    $_SESSION['user_id'] = $user['ID_users'];
                    $_SESSION['role'] = $user['role']; // Установите роль пользователя
                    $_SESSION['is_authenticated'] = true;
                } else {
                    echo "<script>alert('Неверные учетные данные');</script>";
                }
            } else {
                echo "<script>alert('Неверные учетные данные');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Пройдите рекапчу');</script>";
        }
    }
}

// Проверка, авторизован ли пользователь
$is_authenticated = isset($_SESSION['auth__email']) && isset($_SESSION['auth__pass']);
$_SESSION['is_authenticated'] = isset($_SESSION['auth__email']) && isset($_SESSION['auth__pass']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="../style.css">
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
        <section class="accountHero">
            <div class="accountHero__container container">
                <h2 class="accountHero__title SoyuzGrotesk section-title">Личный кабинет <?php if ($_SESSION['is_authenticated']) {if  ($_SESSION['role'] == 1) {
					echo ', Админ:3';
				}}?></h2>
                <p class="accountHero__text">
                    <?php if ($_SESSION['is_authenticated']) echo htmlspecialchars($_SESSION['user__name']) . ', ';
							?>добро пожаловать в ваш личный кабинет! Здесь вы найдете все необходимые инструменты для удобного управления вашими проектами.
                </p>
                <div class="accountHero__buttons">
                    
                    <a href="./currentOrder.php" class="accountHero__buttons-button button">посмотреть статус текущего заказа</a>
                    <a href="./orderHistory.php" class="accountHero__buttons-button button">посмотреть историю заказов</a>
                    <a href="./bonuses.php" class="accountHero__buttons-button button">ваши бонусы</a>
                    <a href="https://yandex.ru/maps/org/proksima/1099395401/reviews/?add-review=true&display-text=проксима%20типография&ll=37.575100%2C55.666538&mode=search&sctx=ZAAAAAgBEAAaKAoSCQM%2FqmG%2FyUJAEWRZMPFH1UtAEhIJxJWzd0ZbZT8RhAzk2eVbTz8iBgABAgMEBSgKOABA9K0HSAFqAnJ1nQHNzMw9oAEAqAEAvQEIK86HwgEFyeKdjASCAiXQv9GA0L7QutGB0LjQvNCwINGC0LjQv9C%2B0LPRgNCw0YTQuNGPigIAkgIAmgIMZGVza3RvcC1tYXBz&sll=37.575100%2C55.666538&source=serp_navig&sspn=0.013200%2C0.004843&tab=reviews&text=проксима%20типография&z=16.66" class="accountHero__buttons-button button">оставить отзыв</a>
                    <a href="./upload.php" class="accountHero__buttons-button button">загрузить проект</a>
                    <a href="./calculate.php" class="accountHero__buttons-button button">Калькулятор для расчета цены</a>
                    <a href="./finance.php" class="accountHero__buttons-button button">Финансовый отчет</a>
                    <?php if ($_SESSION['is_authenticated']) {if  ($_SESSION['role'] == 1) {
					echo '<a href="./admin/admin.php" class="accountHero__buttons-button gradient-btn">админ-панель</a>';
				}}?>
                </div>
                <div class="accountHero__exit exit-block">
					<a href="../src/php/logout.php" class="accountHero__exit-btn exit button">выйти</a>
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
            <div class="footer__info">
                <div class="footer__info-text">
                    <p class="footer__info-text-p SoyuzGrotesk">(903) 192-71-20 <br />(495) 33-111-33</p>
                    <p class="footer__info-text-p SoyuzGrotesk">м. "Новые Черемушки", 117418, <br />Москва, ул. Зюзинская, 6, к.2</p>
                    <p class="footer__info-text-p SoyuzGrotesk">Пон едельник - Пятница <br />10:00 - 18:00</p>
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
    <div class="auth popup <?php if ($is_authenticated) echo 'none'; ?>">
        <form method="post" action="./account.php" class="popup__block">
            <p class="popup__block-title">авторизация</p>
            <p class="popup__block-text">E-mail</p>
            <input type="text" class="popup__block-input auth__email" placeholder="E-mail" name="auth__email" />
            <p class="popup__block-text">Пароль</p>
            <input type="password" placeholder="Пароль" class="popup__block-input auth__pass" name="auth__pass" />
            <div class="g-recaptcha" data-sitekey="6LcPs_kpAAAAAEUzIJHh5v2Hr4PbUSgXWryGNToI"></div>
            <button type="submit" class="popup__block-btn button popup-btn auth-btn">авторизоваться</button>
            <p class="popup__block-comment">или <br />если у вас нет аккаунта</p>
            <button type="button" class="popup__block-btn button popup-btn reg-btn">Зарегистрироваться</button>
            <button type="button" class="popup__block-close closeAuth close">✖</button>
        </form>
    </div>
	<script>
			function onClick(e) {
				e.preventDefault();
				grecaptcha.enterprise.ready(async () => {
					const token = await grecaptcha.enterprise.execute(
						'6LcPs_kpAAAAAEUzIJHh5v2Hr4PbUSgXWryGNToI', {
							action: 'LOGIN'
						}
					);
					document.querySelector('.enter-form').submit();
				});
			}
		</script>
    <!-- <div class="reg popup none">
        <form method="post" action="../src/php/registration.php" class="popup__block reg__block">
            <p class="popup__block-title">Регистрация</p>
            <p class="popup__block-text">Имя</p>
            <input type="text" class="popup__block-input reg__name" placeholder="Имя" name="name" />
			<p class="popup__block-text">Фамилия</p>
            <input type="text" class="popup__block-input reg__name" placeholder="Фамилия" name="surname" />
            <p class="popup__block-text">Номер телефона</p>
            <input type="text" class="popup__block-input reg__phone" placeholder="Номер телефона" name="phone" />
            <p class="popup__block-text">E-mail</p>
            <input type="text" class="popup__block-input reg__email" placeholder="E-mail" name="email" />
            <p class="popup__block-text">Пароль</p>
            <input type="password" placeholder="Пароль" class="popup__block-input reg__pass" name="password" />
            <p class="popup__block-text">Подтверждение пароля</p>
            <input type="password" placeholder="Подтверждение пароля" class="popup__block-input reg__pass2" name="passwordConf" />
            <button type="submit" class="popup__block-btn popup-btn button reg-btn">Зарегистрироваться</button>
            <button type="button" class="popup__block-close close closeReg">✖</button>
        </form>
    </div> -->

<div class="reg popup none">
    <!-- Шаг 1: регистрация -->
    <form id="reg-form-step1" class="popup__block reg__block">
        <p class="popup__block-title">Регистрация</p>

        <p class="popup__block-text">Имя</p>
        <input type="text" name="name" class="popup__block-input" placeholder="Имя" required />

        <p class="popup__block-text">Фамилия</p>
        <input type="text" name="surname" class="popup__block-input" placeholder="Фамилия" required />

        <p class="popup__block-text">Номер телефона</p>
        <input type="text" name="phone" class="popup__block-input" placeholder="Телефон" required />

        <p class="popup__block-text">E-mail</p>
        <input type="email" name="email" class="popup__block-input" placeholder="E-mail" required />

        <p class="popup__block-text">Пароль</p>
        <input type="password" name="password" class="popup__block-input" placeholder="Пароль" required />

        <p class="popup__block-text">Подтверждение пароля</p>
        <input type="password" name="passwordConf" class="popup__block-input" placeholder="Подтверждение пароля" required />

            <button type="button" class="popup__block-close close closeReg">✖</button>
        <button type="submit" class="popup__block-btn popup-btn button reg-btn">Продолжить</button>
    </form>

    <!-- Шаг 2: подтверждение кода -->
    <form id="reg-form-step2" class="popup__block reg__block" style="display: none;">
        <p class="popup__block-title">Подтверждение</p>
        <p class="popup__block-text">Введите код из письма</p>
        <input type="text" name="code" class="popup__block-input" placeholder="Код подтверждения" required />
        <input type="hidden" name="email" id="hidden-email" />
        <button type="submit" class="popup__block-btn popup-btn button reg-btn">Подтвердить</button>
    </form>
</div>


<script>
document.getElementById('reg-form-step1').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('../src/php/registration.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Скрыть шаг 1, показать шаг 2
            form.style.display = 'none';
            document.getElementById('reg-form-step2').style.display = 'block';

            // Передаём email скрыто для проверки кода
            document.getElementById('hidden-email').value = formData.get('email');
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error('Ошибка:', err);
        alert('Произошла ошибка на сервере.');
    });
});

document.getElementById('reg-form-step2').addEventListener('submit', function (e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    fetch('../src/php/verify_code.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Вы успешно зарегистрированы!');
            location.reload(); // или перенаправление
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error('Ошибка:', err);
        alert('Произошла ошибка на сервере.');
    });
});
</script>



    <script>
            const authBtn = document.querySelector('.userAuth');
            const authPopup = document.querySelector('.auth');
            const closeAuth = document.querySelector('.closeAuth');
            const regBtn = document.querySelector('.reg-btn');
            const regPopup = document.querySelector('.reg');
            const closeReg = document.querySelector('.closeReg');

            if (authBtn) {
                authBtn.onclick = function (event) {
                    event.preventDefault();
                    authPopup.classList.remove('none');
                }
            }

            if (closeAuth) {
                closeAuth.onclick = function () {
                    authPopup.classList.add('none');
					alert('Вы не авторизированы, вам недоступен личный кабинет.');
					history.go(-1);
                }
            }

            if (regBtn) {
                regBtn.onclick = function () {
                    regPopup.classList.remove('none');
                    authPopup.classList.add('none');
                }
            }

            if (closeReg) {
                closeReg.onclick = function () {
                    authPopup.classList.remove('none');
                    regPopup.classList.add('none');
                }
            }
    </script>
    <script type="module" src="../main.js"></script>
	</body>

</html>