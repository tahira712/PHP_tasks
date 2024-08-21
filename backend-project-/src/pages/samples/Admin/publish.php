<?php
include '../db_connection.php'; 
$posts = [];
try {
    $stmt = $conn->query('SELECT * FROM posts');
    $posts = $stmt->fetchAll();
} catch (Exception $e) {
    echo 'Database query error: ' . $e->getMessage();
}

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
    <title>Manage Posts</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Manage Posts</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Content</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars($post['id']); ?></td>
                    <td><?php echo htmlspecialchars($post['title']); ?></td>
                    <td><?php echo htmlspecialchars($post['category_id']); ?></td>
                    <td><?php echo htmlspecialchars(substr($post['content'], 0, 100)) . '...'; ?></td>
                    <td>
                        <form method="POST" action='<?php if ($post['published']) echo 'manage_posts.php'; else echo 'publish.php'; ?>'>
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                            <input type="hidden" name="published" value="0">
                            <input type="checkbox" name="published" value="1" <?php if ($post['published']) echo 'checked'; ?>>
                            <button type="submit" class="btn btn-primary btn-sm"><?php if ($post['published']) echo 'Unpublish'; else echo 'Publish'; ?></button>
                        </form>
                     
                    </td>
                    <td>
                        <a href="../user/blogs/blog_detail.php?id=<?php echo htmlspecialchars($post['id']); ?>" class="btn btn-primary btn-sm">See</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
