<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'testdb';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Ошибка подключения к базе данных: ' . $conn->connect_error);
}
?>

