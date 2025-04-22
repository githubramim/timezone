<?php
header('Content-Type: application/json');

if (!isset($_GET['zone1']) || !isset($_GET['zone2'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$zone1 = $_GET['zone1'];
$zone2 = $_GET['zone2'];

try {
    $date1 = new DateTime("now", new DateTimeZone($zone1));
    $date2 = new DateTime("now", new DateTimeZone($zone2));

    $diff = $date1->diff($date2);
    $hours = $diff->h + ($diff->days * 24);
    $minutes = $diff->i;
    $sign = ($date1 > $date2) ? '+' : '-';

    echo json_encode([
        "time1" => $date1->format("c"),
        "time2" => $date2->format("c"),
        "difference" => "{$sign}{$hours} ঘণ্টা {$minutes} মিনিট"
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => "Invalid timezone"]);
}
