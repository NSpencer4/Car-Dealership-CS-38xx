<?php
$servername = 'localhost';
$cust_email = 'root';
$cust_password = '';
$dbname = 'bhowdy';

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname", $cust_email, $cust_password);
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo $error_message;
    exit();
}