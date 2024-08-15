<?php
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dsn = 'mysql:host=localhost;dbname=backend=project';
$dbUsername = 'root';
$dbPassword = '';

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $father_name = $_POST['father_name'];
    $email = $_POST['email'];

    $profileImage = '';
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $destFilePath = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                $profileImage = $newFileName;
            } else {
                echo '<div class="alert alert-danger" role="alert">Error moving the file</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Invalid file extension</div>';
        }
    }

    $otp = rand(100000, 999999);
    $otpExpiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, birth_date, gender, first_name, last_name, father_name, email, profile_image, otp, otp_expiry) VALUES (:username, :password, :birth_date, :gender, :first_name, :last_name, :father_name, :email, :profile_image, :otp, :otp_expiry)");
        $stmt->bindParam(':username', $username);
        
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':birth_date', $birth_date);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':father_name', $father_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':profile_image', $profileImage);
        $stmt->bindParam(':otp', $otp);
        $stmt->bindParam(':otp_expiry', $otpExpiry);

        $stmt->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'huseynovatahire2004@gmail.com';
            $mail->Password = 'nidb vxax uczl okxl';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('tahireh916@gmail.com', 'Tahire Huseynova');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Code';
            $mail->Body = "Your OTP code is <b>$otp</b> and it will expire on <b>$otpExpiry</b>";

            $mail->send();
            echo '<div class="alert alert-success" role="alert">Message has been sent</div>';
            header("Location: verify_otp.php?username=$username");
            exit();
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: ' . $mail->ErrorInfo . '</div>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $e->getMessage() . '</div>';
    }
}

$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Register</h2>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="birth_date">Birth Date:</label>
                <input type="date" class="form-control" id="birth_date" name="birth_date">
            </div>
            <div class="form-group">
                <label>Gender:</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="male" name="gender" value="male">
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="female" name="gender" value="female">
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" class="form-control" id="first_name" name="first_name">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
            <div class="form-group">
                <label for="father_name">Father's Name:</label>
                <input type="text" class="form-control" id="father_name" name="father_name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" class="form-control-file" id="profile_image" name="profile_image">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="login.php" class="btn btn-secondary">Login</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>