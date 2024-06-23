<?php
$host_foto = '127.0.0.1';
$dbname_foto = 'talentos';
$user_foto = 'root';
$pass_foto = '';
$charset_foto = 'utf8mb4';

$dsn_foto = "mysql:host=$host_foto;dbname=$dbname_foto;charset=$charset_foto";
$options_foto = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo_foto = new PDO($dsn_foto, $user_foto, $pass_foto, $options_foto);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
