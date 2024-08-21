<?php
session_start();
require '../db_connection.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../user/user_pages/login.php');
    exit();
}
// else{
//     header('Location: ../Admin/create.php');
//     exit();
// }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_category'])) {
        $category_name = trim($_POST['category_name']);

        try {
            $sql = "INSERT INTO categories (name) VALUES (:name)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
            $stmt->execute();
            $success_message = "<div class='alert alert-success' role='alert'>Category created successfully.</div>";
        } catch (PDOException $e) {
            $error_message = "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } elseif (isset($_POST['update_category'])) {
        $category_id = intval($_POST['category_id']);
        $category_name = trim($_POST['category_name']);

        try {
            $sql = "UPDATE categories SET name = :name WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':name', $category_name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $category_id, PDO::PARAM_INT);
            $stmt->execute();
            $success_message = "<div class='alert alert-success' role='alert'>Category updated successfully.</div>";
        } catch (PDOException $e) {
            $error_message = "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
        $category_id = intval($_POST['category_id']);

        try {
            $sql_update_posts = "UPDATE posts SET category_id = NULL WHERE category_id = :category_id";
            $stmt_update_posts = $conn->prepare($sql_update_posts);
            $stmt_update_posts->bindParam(':category_id', $category_id, PDO::PARAM_INT);
            $stmt_update_posts->execute();

            $sql_delete_category = "DELETE FROM categories WHERE id = :id";
            $stmt_delete_category = $conn->prepare($sql_delete_category);
            $stmt_delete_category->bindParam(':id', $category_id, PDO::PARAM_INT);
            $stmt_delete_category->execute();

            $success_message = "<div class='alert alert-success' role='alert'>Category deleted successfully.</div>";
        } catch (PDOException $e) {
            $error_message = "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
    }


}
try {
    $sql_categories = "SELECT * FROM categories";
    $stmt_categories = $conn->query($sql_categories);
    $categories = $stmt_categories->fetchAll();
} catch (PDOException $e) {
    $error_message = "<div class='alert alert-danger' role='alert'>Error fetching categories: " . htmlspecialchars($e->getMessage()) . "</div>";
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/user_pages/login.php');
    exit();
}
// else{
//     header('Location: ../Admin/create.php');
//     exit();
// }

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
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit();
}

$base_image_path = '../uploads/';
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

$sql_all_posts = "SELECT posts.*, categories.name AS category_name 
                  FROM posts 
                  LEFT JOIN categories ON posts.category_id = categories.id";
$stmt_all_posts = $conn->query($sql_all_posts);
$posts = $stmt_all_posts->fetchAll();

$sql_recent_posts = "SELECT posts.*, categories.name AS category_name 
                     FROM posts 
                     LEFT JOIN categories ON posts.category_id = categories.id 
                     ORDER BY posts.id DESC 
                     LIMIT 5";
$stmt_recent_posts = $conn->query($sql_recent_posts);
$recent_posts = $stmt_recent_posts->fetchAll();

$sql_top_posts = "SELECT posts.*, categories.name AS category_name 
                  FROM posts 
                  LEFT JOIN categories ON posts.category_id = categories.id 
                  ORDER BY posts.id DESC 
                  LIMIT 5";
$stmt_top_posts = $conn->query($sql_top_posts);
$top_posts = $stmt_top_posts->fetchAll();


function fetchResults($pdo, $query) {
    $stmt = $pdo->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$queryDaily = "
    SELECT DATE(created_at) AS date, COUNT(*) AS created_count
    FROM posts
    GROUP BY DATE(created_at)
    ORDER BY DATE(created_at);
";
$dailyCounts = fetchResults($conn, $queryDaily);

$queryMonthly = "
    SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS created_count
    FROM posts
    GROUP BY DATE_FORMAT(created_at, '%Y-%m')
    ORDER BY DATE_FORMAT(created_at, '%Y-%m');
";
$monthlyCounts = fetchResults($conn, $queryMonthly);

$queryCategories = "
    SELECT category_id, COUNT(*) AS blog_count
    FROM posts
    GROUP BY category_id
    ORDER BY blog_count DESC;
";
$categoryCounts = fetchResults($conn, $queryCategories);




?>