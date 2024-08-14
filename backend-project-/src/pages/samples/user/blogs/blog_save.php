<?php
require '../../db_connection.php';

if (!isset($conn)) {
    die('Database connection not established.');
}

// Get form data
$id = isset($_POST['id']) ? intval($_POST['id']) : null;
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
$category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : null;
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;
$is_published = isset($_POST['published']) ? 1 : 0; 

if ($id) {
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ?, category_id = ?, published = ?, user_id = ? WHERE id = ?");
    $stmt->execute([$title, $content, $category_id, $is_published, $user_id, $id]);
} else {
    $stmt = $conn->prepare("INSERT INTO posts (title, content, category_id, published, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $content, $category_id, $is_published, $user_id]);
}

header('Location: ../user_pages/dashboard.php'); 
exit;
?>
