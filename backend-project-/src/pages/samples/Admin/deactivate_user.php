<?php
require '../db_connection.php';

try {
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);

        $sql = "SELECT is_active FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "User not found.";
            exit();
        }

        $is_active = $stmt->fetchColumn();

        $new_status = $is_active ? 0 : 1;

        $sql = "UPDATE users SET is_active = :is_active WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':is_active', $new_status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: create.php");
            exit();
        } else {
            echo "Failed to update user status.";
        }
    } else {
        echo "No user ID provided.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

$conn = null;
?>
