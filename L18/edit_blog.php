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


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

 
    $sql = "UPDATE blogs SET title = ?, content = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$title, $content, $blog_id]);

    header('Location: blog_detail.php?id=' . $blog_id);
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Blog</h1>
    <form method="post">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($blog['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10" required><?php echo htmlspecialchars($blog['content']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="blog_detail.php?id=<?php echo urlencode($blog_id); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
