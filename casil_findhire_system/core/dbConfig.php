<?php

$host = 'localhost';
$dbname = 'casil_findhire';
$username = 'root';
$password = '';             


$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";


try {
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}
?>
