
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="blurry">

    <?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $uploadDirectory = "uploads/";
    $uploadedFiles = [];

    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['files']['name'][$key];
        $file_tmp = $_FILES['files']['tmp_name'][$key];
        $file_type = $_FILES['files']['type'][$key];
        $file_size = $_FILES['files']['size'][$key];

        $unique_filename = uniqid() . "_" . time() . "_" . $file_name;
        $destination = $uploadDirectory . $unique_filename;

        if ($file_size > 5 * 1024 * 1024) {
            echo '<h2 style="color: red;">File size exceeds the limit (5MB).</h2><br>';
            continue; 
        }

        if (move_uploaded_file($file_tmp, $destination)) {
            $uploadedFiles[] = $destination;
        } 
    }

    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;

    header('Location: login.php');
    exit;
}
?>
    </div>
</body>
</html>