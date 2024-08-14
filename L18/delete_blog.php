<?php
session_start();
require "config.php";


if (!isset($_GET['id'])) {
    header('Location: main.php');
    exit();
}

$blog_id = $_GET['id'];


$sql = "DELETE FROM blogs WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$blog_id]);

header('Location: main.php');
exit();
