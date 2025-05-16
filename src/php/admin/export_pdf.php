<?php
require '../../../vendor/autoload.php';

use Dompdf\Dompdf;

$export = $_POST['export'] ?? [];

$html = '
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h2 { margin-top: 20px; }
        ul { padding-left: 20px; }
        img { margin-top: 10px; }
        .chart-data { font-size: 12px; margin-top: 10px; }
    </style>
</head>
<body>
';

if (in_array('calendar', $export)) {
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';
    $totalOrders = $_POST['totalOrders'] ?? 0;
    $totalRevenue = $_POST['totalRevenue'] ?? 0;
    $popularProduct = $_POST['popularProduct'] ?? '—';
    $totalQuestions = $_POST['totalQuestions'] ?? 0;

    // Проверка на пустые даты
    $fromText = $from ? $from : 'Не выбрано';
    $toText = $to ? $to : 'Не выбрано';

    $html .= "<h2>Фильтр по дате</h2>
              <p><strong>Дата начала:</strong> $fromText</p>
              <p><strong>Дата окончания:</strong> $toText</p>
              <h3>Статистика:</h3>
              <ul>
                <li>Всего заказов: $totalOrders</li>
                <li>Общая выручка: $totalRevenue ₽</li>
                <li>Топ продукт: $popularProduct</li>
                <li>Вопросов: $totalQuestions</li>
              </ul>";
}

if (in_array('charts', $export) && !empty($_POST['chartsImage'])) {
    $imageData = $_POST['chartsImage'];
    $html .= "<h2>Графики</h2>";
    $html .= "<img src='$imageData' style='max-width: 100%;'>";

    // Добавим текстовую расшифровку данных из графиков
    $chartTextData = $_POST['chartTextData'] ?? ''; // например: "Услуга A: 45\nУслуга B: 32"

    if ($chartTextData) {
        $html .= "<div class='chart-data'><pre>$chartTextData</pre></div>";
    }
}


$html .= '</body></html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("export.pdf", ["Attachment" => false]);
exit;