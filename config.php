<?php
$host = 'localhost';
$db = 'financial_db';
$user = 'root';
$pass = 'sf6210sf';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("連線失敗: " . $conn->connect_error);
}
session_start();
?>