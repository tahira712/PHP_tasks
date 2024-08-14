<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
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
} catch (PDOException $e) {
    echo "<div class='alert alert-danger' role='alert'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-container {
            padding: 20px;
        }

        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: contain;
            overflow: hidden;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="profile-container">
            <h1 class="mb-4">Profile</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-image">
                        <?php
                        $imagePath = htmlspecialchars('./uploads/' . $user['profile_image']);
                        echo "<img src=\"$imagePath\" alt=\"Profile Image\">";
                        ?>
                    </div>
                </div>
                <div class="col-md-8">
                    <dl class="row">
                        <dt class="col-sm-4">Name:</dt>
                        <dd class="col-sm-8">
                            <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></dd>
                        <dt class="col-sm-4">Username:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['username']); ?></dd>
                        <dt class="col-sm-4">Birth Date:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['birth_date']); ?></dd>
                        <dt class="col-sm-4">Gender:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['gender']); ?></dd>
                        <dt class="col-sm-4">Father's Name:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['father_name']); ?></dd>
                    </dl>
                    
                    <a href="update.php" class="btn btn-primary">Update Profile</a>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
