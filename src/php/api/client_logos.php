<?php
header('Content-Type: application/json');

// Папка с логотипами
$dir = __DIR__ . './../../img/client_logos';
$baseUrl = '../src/img/client_logos/';

if (!is_dir($dir)) {
    echo json_encode([]);
    exit;
}

$files = scandir($dir);
$logos = [];

foreach ($files as $file) {
    if ($file === '.' || $file === '..') continue;

    $ext = pathinfo($file, PATHINFO_EXTENSION);
    if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'webp', 'gif', 'svg'])) {
        $logos[] = [
            'url' => $baseUrl . $file,
            'name' => pathinfo($file, PATHINFO_FILENAME)
        ];
    }
}

echo json_encode($logos);