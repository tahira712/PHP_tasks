<?php
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dsn = 'mysql:host=localhost;dbname=backend_project;charset=utf8'; 
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
    $uploadFileDir = './uploads/';
    
    if (!is_dir($uploadFileDir)) {
        mkdir($uploadFileDir, 0755, true); 
    }

    if (isset($_FILES['profile_image'])) {
        if ($_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['profile_image']['tmp_name'];
            $fileName = $_FILES['profile_image']['name'];
            $fileSize = $_FILES['profile_image']['size'];
            $fileType = $_FILES['profile_image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
    
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $destFilePath = $uploadFileDir . $newFileName;
    
                if (move_uploaded_file($fileTmpPath, $destFilePath)) {
                    echo '<div class="alert alert-success" role="alert">File successfully uploaded</div>';
                    $profileImage = $newFileName;
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error moving the file</div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">Invalid file extension</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Error uploading file: ' . $_FILES['profile_image']['error'] . '</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">No file was uploaded</div>';
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
            $mail->Body    = "Your OTP code is <b>$otp</b> and it will expire on <b>$otpExpiry</b>";

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
