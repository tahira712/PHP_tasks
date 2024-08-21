<?php
session_start();
include '../../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ./login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birth_date = $_POST['birth_date'];
    $profile_image = $_FILES['profile_image'];

    $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, birth_date = :birth_date";
    
    if ($profile_image['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        $file_name = basename($profile_image['name']);
        $target_file = $upload_dir . $file_name;
        if (move_uploaded_file($profile_image['tmp_name'], $target_file)) {
            $sql .= ", profile_image = :profile_image";
        } else {
            echo "<div class='alert alert-danger' role='alert'>File upload failed.</div>";
        }
    }

    $sql .= " WHERE id = :id";
    
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':birth_date', $birth_date, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        if (isset($file_name)) {
            $stmt->bindParam(':profile_image', $file_name, PDO::PARAM_STR);
        }
        $stmt->execute();
        echo "<div class='alert alert-success' role='alert'>Profile updated successfully.</div>";
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
}

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "<div class='alert alert-danger' role='alert'>User not found.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Profile</h2>
        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo htmlspecialchars($user['birth_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
                <small class="form-text text-muted">Current image: <?php echo htmlspecialchars($user['profile_image'] ?: 'default.jpg'); ?></small>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
