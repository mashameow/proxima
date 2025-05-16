<?php
// Подключение к базе данных
$db = mysqli_connect('localhost', 'root', '', 'proxima');
if (!$db) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

// Удаление заказа
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ID_orders'])) {
    $stmt = mysqli_prepare($db, "DELETE FROM orders WHERE ID_orders = ?");
    mysqli_stmt_bind_param($stmt, "i", $_POST['ID_orders']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location: order.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>Админ-панель</title>
  <link rel="stylesheet" href="../../style.css">
</head>
<body>
<main class="admin">
  <aside class="admin__nav">
    <a href="../../index.php" title='Вернуться на главную страницу' class="admin__nav-link">
      <img src="../../src/img/logoBlack.png" alt="logo" class="admin__nav-img"/>
    </a>
    <ul class="admin__nav-list">
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Заказы</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Пользователи</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Вопросы</a></li>
      <li><a href="#" class="admin__nav-link  header__nav-menu-link">Настройки</a></li>
      <li><a href="../account.php" class="admin__nav-link  header__nav-menu-link">Выход</a></li>
    </ul>
  </aside>

  <section class="adminHero">
    <div class="heroHeader">
      <h2 class="dashboard__title admin__tite">Таблица "Заказы"</h2>
    </div>  

    <table border="1" cellpadding="8" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Пользователь</th>
          <th>Услуга</th>
          <th>Продукт</th>
          <th>Количество</th>
          <th>Дата создания</th>
          <th>Дата выполнения</th>
          <th>Бонусы +</th>
          <th>Бонусы -</th>
          <th>Цена</th>
          <th>Сумма</th>
          <th>Статус</th>
          <th>Действия</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "
          SELECT o.ID_orders, u.name AS user_name, s.name AS service_name, p.name AS product_name,
                 o.quantity, o.created_at, o.completionDate, o.bonusesPlus, o.bonusesMinus,
                 o.price, o.total_price, st.name AS status_name
          FROM orders o
          JOIN users u ON o.ID_users = u.ID_users
          JOIN servises s ON o.ID_servises = s.ID_servises
          JOIN products p ON o.ID_products = p.ID_products
          JOIN status st ON o.ID_status = st.ID_status
        ";
        $result = mysqli_query($db, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['ID_orders']}</td>";
            echo "<td>{$row['user_name']}</td>";
            echo "<td>{$row['service_name']}</td>";
            echo "<td>{$row['product_name']}</td>";
            echo "<td>{$row['quantity']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td>{$row['completionDate']}</td>";
            echo "<td>{$row['bonusesPlus']}</td>";
            echo "<td>{$row['bonusesMinus']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['total_price']}</td>";
            echo "<td>{$row['status_name']}</td>";
            echo "<td>
                    <button onclick=\"editOrder({$row['ID_orders']})\">Изменить</button>
                    <form method='POST' action='' style='display:inline'>
                        <input type='hidden' name='ID_orders' value='{$row['ID_orders']}'>
                        <button type='submit' onclick=\"return confirm('Удалить заказ?')\">Удалить</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </section>
</main>
</body>
</html>
