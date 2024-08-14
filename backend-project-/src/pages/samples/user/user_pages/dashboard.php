
<?php
session_start();
include '../../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location:./login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) {
        echo "<div class='alert alert-danger' role='alert'>User not found.</div>";
        exit();
    }

    if ($user['role'] === 'admin') {
        header('Location: Admin/create.php');
        exit();
    }

} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit();
}

$base_image_path = './uploads/';

$sql_posts = "SELECT posts.*, categories.name AS category_name 
              FROM posts 
              LEFT JOIN categories ON posts.category_id = categories.id 
              WHERE posts.user_id = :user_id";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_posts->execute();
$posts = $stmt_posts->fetchAll();

$sql_recent = "SELECT posts.*, categories.name AS category_name 
                FROM posts 
                LEFT JOIN categories ON posts.category_id = categories.id 
                WHERE posts.user_id = :user_id 
                ORDER BY posts.id DESC 
                LIMIT 5";
$stmt_recent = $conn->prepare($sql_recent);
$stmt_recent->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_recent->execute();
$recent_posts = $stmt_recent->fetchAll();

$sql_top = "SELECT posts.*, categories.name AS category_name 
             FROM posts 
             LEFT JOIN categories ON posts.category_id = categories.id 
             WHERE posts.user_id = :user_id 
             ORDER BY posts.id DESC 
             LIMIT 5";
$stmt_top = $conn->prepare($sql_top);
$stmt_top->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_top->execute();
$top_posts = $stmt_top->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar { background: #f8f9fa; padding: 10px; }
        .circle {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            overflow: hidden;
        }
        .circle img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light">
        <div class="container">
            <div class="d-flex align-items-center">
                <div class="circle">
                    <img src="<?php echo htmlspecialchars($base_image_path . ($user['profile_image'] ?: 'default.jpg')); ?>" alt="Profile Image">
                </div>
                <div class="ml-3">
                    <h5><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                    <p class="mb-0"><?php echo htmlspecialchars($user['birth_date']); ?></p>
                </div>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Welcome to your dashboard</h2>
        <a href="../blogs/blog_form.php"><button class="btn btn-primary">Create Blog</button></a>

        <h2 class="mt-5 mb-4">Your Posts</h2>
        <div class="row">
            <?php if (empty($posts)): ?>
                <p>No posts found.</p>
            <?php else: ?>
                <?php foreach ($posts as $blog): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($blog['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($blog['content'], 0, 100)) . '...' ?></p>
                                <p class="card-text"><small class="text-muted">Category: <?= htmlspecialchars($blog['category_name']) ?></small></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
