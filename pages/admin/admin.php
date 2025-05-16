<?php
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;

$fromDate = $from ? date('Y-m-d', strtotime($from)) : null;
$toDate = $to ? date('Y-m-d', strtotime($to)) : null;

$whereClause = '';
if ($fromDate && $toDate) {
    $whereClause = "WHERE created_at BETWEEN '$fromDate 00:00:00' AND '$toDate 23:59:59'";
} elseif ($fromDate) {
    $whereClause = "WHERE created_at >= '$fromDate 00:00:00'";
} elseif ($toDate) {
    $whereClause = "WHERE created_at <= '$toDate 23:59:59'";
}

$totalOrders = $db->query("SELECT COUNT(*) FROM orders $whereClause")->fetch_row()[0];
$totalRevenue = $db->query("SELECT SUM(total_price) FROM orders $whereClause")->fetch_row()[0] ?? 0;

$popularProductResult = $db->query("
    SELECT p.nameProduct, COUNT(o.ID_orders) as count
    FROM orders o
    JOIN products p ON o.ID_products = p.ID_products
    GROUP BY o.ID_products
    ORDER BY count DESC
    LIMIT 1
");
$popularProduct = $popularProductResult->fetch_assoc();

$totalQuestions = $db->query("SELECT COUNT(*) FROM questions")->fetch_row()[0] ?? 0;

$revenueByMonthResult = $db->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as revenue
    FROM orders
    GROUP BY month
    ORDER BY month
");
$revenueByMonthData = $revenueByMonthResult->fetch_all(MYSQLI_ASSOC);

$ordersByProductResult = $db->query("
    SELECT p.nameProduct, COUNT(o.ID_orders) as count
    FROM orders o
    JOIN products p ON o.ID_products = p.ID_products
    GROUP BY o.ID_products
");
$ordersByProductData = $ordersByProductResult->fetch_all(MYSQLI_ASSOC);

$ordersByStatusResult = $db->query("
    SELECT s.name, COUNT(*) as count
    FROM orders o
    JOIN status s ON o.ID_status = s.ID_status
    GROUP BY o.ID_status
");
$ordersByStatusData = $ordersByStatusResult->fetch_all(MYSQLI_ASSOC);

$revenueByProductResult = $db->query("SELECT p.nameProduct, SUM(o.total_price) as total
    FROM orders o
    JOIN products p ON o.ID_products = p.ID_products
    GROUP BY o.ID_products");
$revenueByProductData = $revenueByProductResult->fetch_all(MYSQLI_ASSOC);

$ordersCountByMonthResult = $db->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
    FROM orders
    GROUP BY month
    ORDER BY month");
$ordersCountByMonthData = $ordersCountByMonthResult->fetch_all(MYSQLI_ASSOC);
$ordersByWeekdayResult = $db->query("
    SELECT 
        DAYNAME(created_at) AS weekday,
        COUNT(*) AS count
    FROM orders
    GROUP BY weekday
    ORDER BY FIELD(weekday, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
");
$ordersByWeekdayData = $ordersByWeekdayResult->fetch_all(MYSQLI_ASSOC);
$ordersByServiceResult = $db->query("
    SELECT s.nameServises AS name, COUNT(o.ID_orders) AS count
    FROM orders o
    JOIN servises s ON o.ID_servises = s.ID_servises
    GROUP BY o.ID_servises
");
$ordersByServiceData = $ordersByServiceResult->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель</title>
  <link rel="stylesheet" href="../../style.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<main class="admin">
  <aside class="admin__nav">
    <a href="../../index.php" title='Вернуться на главную страницу' class="admin__nav-link"><img src="../../src/img/logoBlack.png" alt="logo" class="admin__nav-img"/></a>
    <ul class="admin__nav-list">
      <li><a href="./order.php" class="admin__nav-link  header__nav-menu-link">Заказы</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Пользователи</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Вопросы</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Настройки</a></li>
      <li><a href="../account.php" class="admin__nav-link  header__nav-menu-link">Выход</a></li>
    </ul>
  </aside>
  <section class="dashboard">
    <div class="heroHeader dashboard__heroHeader">
      <h2 class="dashboard__title admin__tite">Админ-панель</h2>
      <div class="heroHeader__btn">
        <button class="exportPDF-btn gradient-btn" onclick="togglePopup()">Скачать PDF</button>
      </div>
    </div>

    <!-- Фильтр по дате -->
     <div class="filter__block">

       <form class="dashboard__filter" method="GET">
         <label>
           Дата начала:
           <input type="date" class='dashboard__filter-date input' name="from" value="<?= htmlspecialchars($from ?? '') ?>">
         </label>
         <label>
           Дата окончания:
           <input type="date" class='dashboard__filter-date input' name="to" value="<?= htmlspecialchars($to ?? '') ?>">
         </label>
         <button type="submit" class='gradient-btn'>Применить</button>
         <?php if ($from || $to): ?>
           <a href="./admin.php" class="dashboard__reset-btn  button">Сбросить</a>
         <?php endif; ?>
       </form>
       <div class="dashboard__stats">
         <div class="dashboard__stat">
           <h3 class='dasboard__stat-title'>Всего заказов</h3>
           <p class='dasboard__stat-text'><?= $totalOrders ?></p>
         </div>
         <div class="dashboard__stat">
           <h3 class='dasboard__stat-title'>Общая выручка</h3>
           <p class='dasboard__stat-text'><?= number_format($totalRevenue, 2) ?> ₽</p>
         </div>
         <div class="dashboard__stat">
           <h3 class='dasboard__stat-title'>Топ продукт</h3>
           <p class='dasboard__stat-text'><?= $popularProduct['nameProduct'] ?? '—' ?></p>
         </div>
         <div class="dashboard__stat">
           <h3 class='dasboard__stat-title'>Вопросов</h3>
           <p class='dasboard__stat-text'><?= $totalQuestions ?></p>
         </div>
       </div>
     </div>
    <div class="dashboard__chart">
  
<div class="dashboard__chart-row">
  <div class="dashboard__chart-block">
    <canvas id="revenueChart"></canvas>
  </div>
  <div class="dashboard__chart-block">
    <canvas id="ordersChart"></canvas>
  </div>
</div>
  <div class="dashboard__chart-block chart-fix" style="flex: 2;">
    <div class="chart-title">Доход по продукции</div>
    <canvas id="revenueByProductChart"></canvas>
</div>
<div class="dashboard__chart-block chart-fix">
      <div class="chart-title">Популярность услуг</div>
      <canvas id="servicesChart"></canvas>
    </div>
   <div class="dashboard__chart-block chart-fix">
  <div class="chart-title">Заказы по дням недели</div>
  <canvas id="ordersByWeekdayChart"></canvas>
</div>
  <div class="dashboard__chart-block chart-fix">
    <div class="chart-title">Статистика заказов</div>
    <canvas id="statusChart"></canvas>
  </div>
</div>

</div>
</section>
</main>
<div id="exportPopup" class=" exportPopup popup hidden">
  <div class="popup__content">
    <form method="POST" class="popup__block exportPopup__block" action="../../src/php/admin/export_pdf.php" target="_blank">
      <h3 class="popup__block-title">Что выгрузить?</h3>
      <label><input type="checkbox" name="export[]" value="calendar"> Таблица</label><br>
      <label><input type="checkbox" name="export[]" value="charts"> Графики</label><br><br>

      <!-- Статистика -->
      <input type="hidden" name="totalOrders" value="<?= $totalOrders ?>">
      <input type="hidden" name="totalRevenue" value="<?= number_format($totalRevenue, 2) ?>">
      <input type="hidden" name="popularProduct" value="<?= $popularProduct['nameProduct'] ?? '—' ?>">
      <input type="hidden" name="totalQuestions" value="<?= $totalQuestions ?>">
      <input type="hidden" name="from" value="<?= htmlspecialchars($from ?? '') ?>">
      <input type="hidden" name="to" value="<?= htmlspecialchars($to ?? '') ?>">

      <!-- Скрипт добавит сюда base64 изображение графиков -->
      <input type="hidden" name="chartsImage" id="chartsImageInput">

      <button type="submit" class="gradient-btn" onclick="prepareChartsImage()">Сформировать PDF</button>
      <button type="button" class="button" onclick="togglePopup()">Отмена</button>
    </form>

  </div>
</div>
<script>
// Данные из PHP
const revenueData = <?= json_encode($revenueByMonthData) ?>;
const ordersByProduct = <?= json_encode($ordersByProductData) ?>;
const ordersByStatus = <?= json_encode($ordersByStatusData) ?>;
const revenueByProduct = <?= json_encode($revenueByProductData) ?>;
function togglePopup() {
    document.getElementById('exportPopup').classList.toggle('hidden');
  }
// График выручки по месяцам
const revenueChart = new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: revenueData.map(r => r.month),
        datasets: [{
            label: 'Выручка по месяцам',
            data: revenueData.map(r => r.revenue),
            borderColor: '#e93ea3',
            fill: false
        }]
    },
    options: { responsive: true }
});

// График заказов по продуктам
const ctx2 = document.getElementById('ordersChart').getContext('2d');
const gradient = ctx2.createLinearGradient(0, 0, ctx2.canvas.width, 0);
gradient.addColorStop(0, '#9bd00c');
gradient.addColorStop(1, '#e93ea3');

const ordersChart = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ordersByProduct.map(p => p.nameProduct),
        datasets: [{
            label: 'Кол-во заказов по продуктам',
            data: ordersByProduct.map(p => p.count),
            backgroundColor: gradient,
            borderRadius: 5
        }]
    },
    options: { responsive: true }
});

// График статуса заказов
const statusChart = new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: ordersByStatus.map(s => s.name),
        datasets: [{
            data: ordersByStatus.map(s => s.count),
            backgroundColor: ['#e93ea3', '#E93E63', '#FFCF0D', '#9bd00c']
        }]
    },
    options: {
  responsive: true,
  maintainAspectRatio: false, // обязательно для кастомной высоты
  plugins: {
    legend: {
      position: 'left'
    }
  }
}
});

// График дохода по продукции
const revenueByProductChart = new Chart(document.getElementById('revenueByProductChart'), {
    type: 'doughnut',
    data: {
        labels: revenueByProduct.map(p => p.nameProduct),
        datasets: [{
            data: revenueByProduct.map(p => p.total),
            backgroundColor: ['#e93ea3', '#E93E63', '#FD3C3F', '#FFCF0D', '#9bd00c', '#0CD08B', '#610CD0']
        }]
    },
    options: {
  responsive: true,
  maintainAspectRatio: false, // обязательно для кастомной высоты
  plugins: {
    legend: {
      position: 'left'
    }
  }
}
});

// График услуг
const ordersByService = <?= json_encode($ordersByServiceData) ?>;
new Chart(document.getElementById('servicesChart'), {
    type: 'bar',
    data: {
        labels: ordersByService.map(s => s.name),
        datasets: [{
            label: 'Количество заказов',
            data: ordersByService.map(s => s.count),
            backgroundColor: '#9bd00c'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        }
    }
});

const ordersByWeekdayData = <?= json_encode($ordersByWeekdayData) ?>;
new Chart(document.getElementById('ordersByWeekdayChart'), {
    type: 'bar',
    data: {
        labels: ordersByWeekdayData.map(w => w.weekday),
        datasets: [{
            label: 'Количество заказов',
            data: ordersByWeekdayData.map(w => w.count),
            backgroundColor: gradient,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
function togglePopup() {
    document.getElementById('exportPopup').classList.toggle('hidden');
}
function prepareChartsImage() {
  const chartsBlock = document.querySelector('.dashboard__chart');
  const checkbox = document.querySelector('input[value="charts"]');
  
  if (checkbox.checked && chartsBlock) {
    html2canvas(chartsBlock).then(canvas => {
      const imageData = canvas.toDataURL('image/png');
      document.getElementById('chartsImageInput').value = imageData;
      document.querySelector('form.exportPopup__block').submit();
    });
    
    // отменим обычную отправку, подождём canvas
    event.preventDefault();
  }
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</body>
</html>
