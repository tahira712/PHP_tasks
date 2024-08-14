<?php
require '../../db_connection.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt_check = $conn->prepare("SELECT id FROM posts WHERE id = ?");
    $stmt_check->execute([$id]);
    $blog = $stmt_check->fetch();
    
    if ($blog) {
        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: ../user_pages/dashboard.php"); 
        exit();
    } else {
        echo "Blog not found.";
    }
} else {
    echo "No blog ID provided.";
}
?>
