<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'proxima');

$userId = $_SESSION['user_id'];

$sql = "SELECT number, created_at, bonusesMinus, bonusesPlus, price 
        FROM orders 
        WHERE ID_users = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$totalBonuses = 0;
$totalPrice = 0;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="../style.css">
  <title>Финансовый отчет</title>
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
  <section class='heroFinance'>
    <div class="heroFinance__container container">
        <div class="heroFinance__header heroHeader">
            <h2 class="heroFinance__title SoyuzGrotesk section-title">Финансовый отчет</h2>
            <div class="heroFinance__header-button">
                <button onclick="exportToExcel()" class="gradient-btn heroFinance__header-button-btn">Скачать в Excel</button>
            </div>
        </div>
      <p class="heroFinance__text">Добро пожаловать на страницу финансового отчета о покупках! Здесь вы можете ознакомиться с подробной информацией о ваших покупках, а также отслеживать свои расходы и анализировать финансовую активность.</p>     

      <table class="heroFinance__table" id="reportTable">
        <tr class="heroFinance__table-row heroFinance__table-header">
          <th class="heroFinance__table-cell table__name" title="Уникальный номер заказа">номер заказа</th>
          <th class="heroFinance__table-cell table__name" title="Дата, когда был оформлен заказ">дата заказа</th>
          <th class="heroFinance__table-cell table__name" title="Количество бонусов, которые были списаны за заказ">спис. бонусы</th>
          <th class="heroFinance__table-cell table__name" title="Количество бонусов, начисленных за заказ">нач. бонусы</th>
          <th class="heroFinance__table-cell table__name" title="Общая стоимость без учета скидок">цена</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr class="heroFinance__table-row">
          <td class="heroFinance__table-cell table__number" title="Уникальный номер заказа">№<?= htmlspecialchars($row['number']) ?></td>
          <td class="heroFinance__table-cell" title="Дата, когда был оформлен заказ"><?= htmlspecialchars($row['created_at']) ?></td>
          <td class="heroFinance__table-cell" title="Количество бонусов, которые были списаны за заказ"><?= htmlspecialchars($row['bonusesMinus']) ?></td>
          <td class="heroFinance__table-cell" title="Количество бонусов, начисленных за заказ"><?= htmlspecialchars($row['bonusesPlus']) ?></td>
          <td class="heroFinance__table-cell" title="Общая стоимость без учета скидок"><?= number_format($row['price'], 2, ',', ' ') ?> руб.</td>
        </tr>
        <?php
          $totalBonuses += $row['bonusesMinus'];
          $totalPrice += $row['price'];
        ?>
        <?php endwhile; ?>

        <tr class="heroFinance__table-row heroFinance__table-footer">
          <td class="heroFinance__table-cell heroFinance__table-footer-label table__name">размер скидок:</td>
          <td class="heroFinance__table-cell heroFinance__table-footer-value table__name" colspan="4" title="Общий размер скидки"><?= number_format($totalBonuses, 0, ',', ' ') ?> руб.</td>
        </tr>
        <tr class="heroFinance__table-row heroFinance__table-footer">
          <td class="heroFinance__table-cell heroFinance__table-footer-label table__name">итоговая цена:</td>
          <td class="heroFinance__table-cell heroFinance__table-footer-value table__name" colspan="4" title="Общая стоимость без учета скидок"><?= number_format($totalPrice, 2, ',', ' ') ?> руб.</td>
        </tr>
      </table>

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

<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
function exportToExcel() {
  const table = document.getElementById("reportTable");
  const wb = XLSX.utils.table_to_book(table, {sheet: "Финансовый отчет"});

  // Установка ширины колонок в 12 символов
  const ws = wb.Sheets["Финансовый отчет"];
  const cols = Array.from({ length: 5 }, () => ({ wch: 14 }));
  ws['!cols'] = cols;

  XLSX.writeFile(wb, "финансовый_отчет_PROXIMA.xlsx");
}
</script>
<script type="module" src="../main.js"></script>
</body>
</html>
