<?php
try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=gestion;charset=utf8", "root", "");
    echo "Database connected successfully<br>";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}   
?>