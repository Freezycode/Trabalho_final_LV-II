<?php
$host_status = '127.0.0.1';
$dbname_status = 'talentos';
$user_status = 'root';
$pass_status = '';
$charset_status = 'utf8mb4';

$dsn_status = "mysql:host=$host_status;dbname=$dbname_status;charset=$charset_status";
$options_status = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo_status = new PDO($dsn_status, $user_status, $pass_status, $options_status);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
