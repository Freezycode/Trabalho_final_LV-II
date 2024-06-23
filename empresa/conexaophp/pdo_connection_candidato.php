<?php
$host = '127.0.0.1';
$dbname = 'talentos';
$user = 'root';
$pass = '';

try {
    $pdo_candidato = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo_candidato->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>
