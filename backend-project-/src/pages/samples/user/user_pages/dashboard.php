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
        header('Location: ../../Admin/create.php');
        exit();
    }

} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit();
}
$base_image_path = '../../uploads/';

$results_per_page = 3; 
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($current_page - 1) * $results_per_page;

$sql_total_posts = "SELECT COUNT(*) AS total FROM posts WHERE user_id = :user_id";
$stmt_total_posts = $conn->prepare($sql_total_posts);
$stmt_total_posts->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_total_posts->execute();
$total_posts = $stmt_total_posts->fetch(PDO::FETCH_ASSOC)['total'];
$total_pages = ceil($total_posts / $results_per_page);

$sql_posts = "SELECT posts.*, categories.name AS category_name 
              FROM posts 
              LEFT JOIN categories ON posts.category_id = categories.id 
              WHERE posts.user_id = :user_id 
              LIMIT :start_from, :results_per_page";
$stmt_posts = $conn->prepare($sql_posts);
$stmt_posts->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt_posts->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt_posts->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
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

// Search functionality
$search_title = isset($_GET['search_title']) ? trim($_GET['search_title']) : '';
$search_creator = isset($_GET['search_creator']) ? trim($_GET['search_creator']) : '';
$search_content = isset($_GET['search_content']) ? trim($_GET['search_content']) : '';
$search_category = isset($_GET['search_category']) ? intval($_GET['search_category']) : '';

$sql_search = "SELECT p.*, c.name AS category_name, u.first_name, u.last_name
                FROM posts p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                WHERE 1=1";

$params = [];

if ($search_title) {
    $sql_search .= " AND p.title LIKE :title";
    $params[':title'] = "%$search_title%";
}

if ($search_creator) {
    $sql_search .= " AND (u.first_name LIKE :creator OR u.last_name LIKE :creator)";
    $params[':creator'] = "%$search_creator%";
}

if ($search_category) {
    $sql_search .= " AND p.category_id = :category_id";
    $params[':category_id'] = $search_category;
}

if ($search_content) {
    $sql_search .= " AND p.content LIKE :content";
    $params[':content'] = '%' . $search_content . '%';
}

$sql_search .= " LIMIT :start_from, :results_per_page";
$stmt_search = $conn->prepare($sql_search);
foreach ($params as $key => $value) {
    $stmt_search->bindValue($key, $value);
}
$stmt_search->bindParam(':start_from', $start_from, PDO::PARAM_INT);
$stmt_search->bindParam(':results_per_page', $results_per_page, PDO::PARAM_INT);
$stmt_search->execute();
$search_results = $stmt_search->fetchAll(PDO::FETCH_ASSOC);

try {
    $sql_categories = "SELECT * FROM categories";
    $stmt_categories = $conn->query($sql_categories);
    $categories = $stmt_categories->fetchAll();
} catch (PDOException $e) {
    $error_message = "<div class='alert alert-danger' role='alert'>Error fetching categories: " . htmlspecialchars($e->getMessage()) . "</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: #f8f9fa;
            padding: 10px;
        }

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
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="circle">
                    <img src="<?php echo htmlspecialchars($base_image_path . ($user['profile_image'] ?: 'default.jpg')); ?>"
                        alt="Profile Image">
                </div>
                <div class="ml-3">
                    <h5><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                    <p class="mb-0"><?php echo htmlspecialchars($user['birth_date']); ?></p>
                </div>
                <a href="edit_profile.php" class="btn btn-secondary">Edit Profile</a>

            </div>
        </div>
    </nav>
    <div class="container mt-4 ">
        <div>
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
                                    <p class="card-text"><small class="text-muted">Category:
                                            <?= htmlspecialchars($blog['category_name']) ?></small></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page - 1])); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>

                    <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                    <li class="page-item <?php echo $page == $current_page ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page])); ?>"><?php echo $page; ?></a>
                    </li>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page + 1])); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="container mt-5">
            <h2 class="mb-4">Search Blogs</h2>
            <form action="dashboard.php" method="GET">
                <div class="form-group">
                    <label for="search_title">Title</label>
                    <input type="text" class="form-control" id="search_title" name="search_title" value="<?php echo htmlspecialchars($search_title); ?>">
                </div>
                <div class="form-group">
                    <label for="search_content">Content</label>
                    <input type="text" class="form-control" id="search_content" name="search_content" value="<?php echo htmlspecialchars($search_content); ?>">
                </div>

                <div class="form-group">
                    <label for="search_creator">Creator</label>
                    <input type="text" class="form-control" id="search_creator" name="search_creator" value="<?php echo htmlspecialchars($search_creator); ?>">
                </div>
                <div class="form-group">
                    <label for="search_category">Category</label>
                    <select class="form-control" id="search_category" name="search_category">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['id']); ?>"
                                <?php echo $search_category == $category['id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="container mt-5">
            <h2 class="mb-4">Search Results</h2>
            <?php if (empty($search_results)): ?>
                <p>No results found.</p>
            <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Creator</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($search_results as $result): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['id']); ?></td>
                                <td><?php echo htmlspecialchars($result['title']); ?></td>
                                <td><?php echo htmlspecialchars(substr($result['content'], 0, 100) . '...'); ?></td>
                                <td><?php echo htmlspecialchars($result['first_name'] . ' ' . $result['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($result['category_name']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <?php if ($current_page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page - 1])); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
                        <li class="page-item <?php echo $page == $current_page ? 'active' : ''; ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page])); ?>"><?php echo $page; ?></a>
                        </li>
                        <?php endfor; ?>

                        <?php if ($current_page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page + 1])); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
