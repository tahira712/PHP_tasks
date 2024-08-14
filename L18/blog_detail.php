
<?php
session_start();
require "config.php";


if (!isset($_GET['id'])) {
    header('Location: index.php'); 
    exit();
}

$blog_id = $_GET['id'];


$sql = "SELECT * FROM blogs WHERE id = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$blog_id]);
$blog = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$blog) {
    header('Location: index.php'); 
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5"><?php echo htmlspecialchars($blog['title']); ?></h1>
    <p><?php echo nl2br(htmlspecialchars($blog['content'])); ?></p>

    <p><a href="index.php" class="btn btn-primary">Back to Profile</a></p>
    <p><a href="edit_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary">Edit</a></p>
    <p><a href="delete_blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-danger">Delete</a></p>
   
</div>
</body>
</html>
