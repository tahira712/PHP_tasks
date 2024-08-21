<?php
require '../db_connection.php';

if (!isset($conn)) {
    die('Database connection not established.');
}

$posts_per_page = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $posts_per_page;

$sql_count = "SELECT COUNT(*) as total_posts FROM posts WHERE published = 1";
$stmt_count = $conn->query($sql_count);
$total_posts = $stmt_count->fetch()['total_posts'];
$total_pages = ceil($total_posts / $posts_per_page);

$sql_posts = "SELECT posts.*, categories.name AS category_name 
              FROM posts 
              LEFT JOIN categories ON posts.category_id = categories.id 
              WHERE posts.published = 1
              ORDER BY posts.id DESC
              LIMIT :start, :limit";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bindValue(':start', $start, PDO::PARAM_INT);
$stmt_posts->bindValue(':limit', $posts_per_page, PDO::PARAM_INT);
$stmt_posts->execute();
$posts = $stmt_posts->fetchAll();

$sql_recent_posts = "SELECT posts.*, categories.name AS category_name 
                     FROM posts 
                     LEFT JOIN categories ON posts.category_id = categories.id
                     WHERE posts.published = 1
                     ORDER BY posts.id DESC 
                     LIMIT 5";
$stmt_recent_posts = $conn->query($sql_recent_posts);
$recent_posts = $stmt_recent_posts->fetchAll();

$sql_top_posts = "SELECT posts.*, categories.name AS category_name 
                  FROM posts 
                  LEFT JOIN categories ON posts.category_id = categories.id
                  WHERE posts.published = 1
                  ORDER BY view_count DESC 
                  LIMIT 5";
$stmt_top_posts = $conn->query($sql_top_posts);
$top_posts = $stmt_top_posts->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $published = isset($_POST['published']) && $_POST['published'] == '1' ? 1 : 0;

        try {
            $stmt = $conn->prepare("UPDATE posts SET published = ? WHERE id = ?");
            $stmt->execute([$published, $id]);

            header('Location: manage_posts.php');
            exit(); 
        } catch (Exception $e) {
            echo 'Update error: ' . $e->getMessage();
        }
    } else {
        echo 'Post ID not set.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">All Posts</h1>
        <div class="row">
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
        </div>

        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>

        <h2 class="mt-5 mb-4">Last 5 Posts</h2>
        <ul class="list-group">
            <?php foreach ($recent_posts as $blog): ?>
                <li class="list-group-item">
                    <a href="?id=<?= htmlspecialchars($blog['id']) ?>" class="stretched-link"><?= htmlspecialchars($blog['title']) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2 class="mt-5 mb-4">Top 5 Posts</h2>
        <ul class="list-group">
            <?php foreach ($top_posts as $blog): ?>
                <li class="list-group-item">
                    <a href="../user/blogs/blog_detail.php?id=<?= htmlspecialchars($blog['id']) ?>" class="stretched-link"><?= htmlspecialchars($blog['title']) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
