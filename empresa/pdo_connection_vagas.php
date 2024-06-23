<?php
$host_vagas = '127.0.0.1';
$dbname_vagas = 'talentos';
$user_vagas = 'root';
$pass_vagas = '';
$charset_vagas = 'utf8mb4';

$dsn_vagas = "mysql:host=$host_vagas;dbname=$dbname_vagas;charset=$charset_vagas";
$options_vagas = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo_vagas = new PDO($dsn_vagas, $user_vagas, $pass_vagas, $options_vagas);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
