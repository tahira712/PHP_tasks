
<?php
$dsn = 'mysql:host=localhost;dbname=blog;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

function createSlug($string) {
    $string = strtolower($string);
    $string = iconv('utf-8', 'ascii//translit', $string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? '';
$slug = $_GET['slug'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $slug = createSlug($title);

        try {
            $stmt = $pdo->prepare("INSERT INTO blog_posts (title, slug, content) VALUES (?, ?, ?)");
            $stmt->execute([$title, $slug, $content]);
            echo "<div class='alert alert-success'>Post created successfully! <a href='?action=view&slug=$slug'>View Post</a></div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    } elseif ($action === 'update') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $slug = createSlug($title);

        try {
            $stmt = $pdo->prepare("UPDATE blog_posts SET title = ?, slug = ?, content = ? WHERE id = ?");
            $stmt->execute([$title, $slug, $content, $id]);
            echo "<div class='alert alert-success'>Post updated successfully! <a href='?action=view&slug=$slug'>View Post</a></div>";
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
        }
    }
}

try {
    $stmt = $pdo->query("SELECT id, title, slug FROM blog_posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Query failed: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Blog Management</h1>

        <?php if ($action === 'create'): ?>
            <h2>Create a New Post</h2>
            <form method="post">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Post</button>
            </form>
        <?php elseif ($action === 'view' && $slug): ?>
            <h2>View Post</h2>
            <?php
            try {
                $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE slug = ?");
                $stmt->execute([$slug]);
                $post = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($post):
            ?>
                <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                <p><?php echo htmlspecialchars($post['content']); ?></p>
                <a href="?action=update&id=<?php echo $post['id']; ?>" class="btn btn-warning">Update Post</a>
            <?php
                else:
                    echo "<div class='alert alert-warning'>Post not found.</div>";
                endif;
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
            ?>
        <?php elseif ($action === 'update' && $id): ?>
            <h2>Update Post</h2>
            <?php
            try {
                $stmt = $pdo->prepare("SELECT * FROM blog_posts WHERE id = ?");
                $stmt->execute([$id]);
                $post = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($post):
            ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($post['id']); ?>">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo htmlspecialchars($post['title']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea id="content" name="content" class="form-control" rows="4" required><?php echo htmlspecialchars($post['content']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </form>
            <?php
                else:
                    echo "<div class='alert alert-warning'>Post not found.</div>";
                endif;
            } catch (PDOException $e) {
                echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
            }
            ?>
        <?php else: ?>
            <h2>Actions</h2>
            <ul class="list-group mb-4">
                <li class="list-group-item">
                    <a href="?action=create" class="btn btn-primary">Create a New Post</a>
                </li>
                
            </ul>
        <?php endif; ?>

        <h2>All Blog Posts</h2>
        <?php if (!empty($posts)): ?>
            <ul class="list-group">
                <?php foreach ($posts as $post): ?>
                    <li class="list-group-item">
                        <a href="?action=view&slug=<?php echo htmlspecialchars($post['slug']); ?>">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <div class="alert alert-info">No posts found.</div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
$pdo = null;
?>
