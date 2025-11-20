<?php
declare(strict_types=1);

session_start();

$DB_HOST = 'sql100.byethost9.com';
$DB_NAME = 'b9_40447648_imoveis_db';
$DB_USER = 'b9_40447648';
$DB_PASS = 'ClairExpedition33.';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    exit("Erro no banco");
}
