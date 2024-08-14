<?php
require '../../db_connection.php';

if (!isset($conn)) {
    die('Database connection not established.');
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    if (filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]])) {
        try {
            $stmt = $conn->prepare("UPDATE posts SET view_count = view_count + 1 WHERE id = ?");
            $stmt->execute([$id]);

            $stmt = $conn->prepare("SELECT posts.*, categories.name AS category_name, users.username AS creator_name 
                                    FROM posts 
                                    LEFT JOIN categories ON posts.category_id = categories.id
                                    LEFT JOIN users ON posts.user_id = users.id
                                    WHERE posts.id = ?");
            $stmt->execute([$id]);
            $post = $stmt->fetch();

            session_start();
            $user_id = $_SESSION['user_id']; 

            if ($post) {
                $is_owner = ($user_id === $post['user_id']);
                
                $stmt_user = $conn->prepare("SELECT role FROM users WHERE id = ?");
                $stmt_user->execute([$user_id]);
                $user = $stmt_user->fetch();
                $is_admin = ($user['role'] === 'admin');
            } else {
                die('Post not found.');
            }

        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    } else {
        die('Invalid post ID.');
    }
} else {
    die('Post ID not provided.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($post['title']) ?></h1>
        <p><small class="text-muted">Creator: <?= htmlspecialchars($post['creator_name']) ?></small></p>
        <p><small class="text-muted">Category: <?= htmlspecialchars($post['category_name']) ?></small></p>
        <p><small class="text-muted">Views: <?= htmlspecialchars($post['view_count']) ?></small></p>
        <div class="mt-3">
            <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
        </div>
        
        <?php if ($is_owner || $is_admin): ?>
            <a href="edit_blog.php?id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-warning">Edit</a>
            <a href="delete_blog.php?id=<?= htmlspecialchars($post['id']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog?');">Delete</a>
        <?php endif; ?>
        
        <a href="index.php" class="btn btn-primary">Back to Posts</a>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
