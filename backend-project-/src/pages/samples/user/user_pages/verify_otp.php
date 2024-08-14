<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    $stored_otp = $_SESSION['otp'];

    if ($otp == $stored_otp) {
        $message = 'OTP verified successfully!';
        $alertClass = 'alert-success';
    } else {
        $message = 'Invalid OTP. Please try again.';
        $alertClass = 'alert-danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Verify OTP</h2>
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $alertClass; ?>" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="otp">OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>">
            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
