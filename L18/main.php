<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Main Page</title>
</head>
<body>

<?php
session_start();
if (isset($_SESSION['user_id'])) { ?>

   

    <?php
} else {
    ?>
    <button>
        <a style="text-decoration: none;color: black" href="register.php">Register</a>
    </button>
    <button>Login</button>

    <?php
}
?>

</body>
</html>

<?php

require "config.php";

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    

    $sql_blogs = "SELECT * FROM blogs WHERE user_id = ?";
    $stmt_blogs = $connection->prepare($sql_blogs);
    $stmt_blogs->execute([$user_id]);
    $blogs = $stmt_blogs->fetchAll(PDO::FETCH_ASSOC);
} else {
    header('Location: login.php');
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Welcome, <?php echo htmlspecialchars($user['name']); ?></h1>
    <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
    <p><a href="create_blog.php" class="btn btn-primary">Create New Blog</a></p>
    <h2>Your Blogs</h2>
    <?php if (count($blogs) > 0): ?>
        <ul class="list-group">
            <?php foreach ($blogs as $blog): ?>
                <li class="list-group-item">
                    <h4><a href="blog_detail.php?id=<?php echo urlencode($blog['id']); ?>"><?php echo htmlspecialchars($blog['title']); ?></a></h4>
                    <p><?php echo htmlspecialchars(substr($blog['content'], 0, 100)) . '...'; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You have no blogs.</p>
    <?php endif; ?>
</div>
</body>
</html>
