<?php
function rateLimit($key, $limit = 5, $seconds = 60) {
    session_start();
    $current_time = time();

    if (!isset($_SESSION['rate_limit'][$key])) {
        $_SESSION['rate_limit'][$key] = [
            'count' => 1,
            'start_time' => $current_time
        ];
        return true;
    }

    $data = &$_SESSION['rate_limit'][$key];

    if ($current_time - $data['start_time'] > $seconds) {
        $data['count'] = 1;
        $data['start_time'] = $current_time;
        return true;
    }

    if ($data['count'] < $limit) {
        $data['count']++;
        return true;
    }

    return false;
}
?>
