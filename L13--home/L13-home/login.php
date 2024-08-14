<?php

session_start();

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    $storedEmail = $_SESSION['email'];
    $storedPassword = $_SESSION['password'];
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $loginEmail = $_POST['email'];
        $loginPassword = $_POST['password'];
        
        if ($loginEmail == $storedEmail && $loginPassword == $storedPassword) {
            
        header('Location:profile.php');
            echo "<a href='index.php'>Logout</a>";
        } else {
            echo "<p>Email or password is incorrect. Please try again.</p>";
        }
    }
} else {
    header('Location: index.php');
    exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
         body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("log.avif");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        h2 {
            font-size: 50px;
        }
        .blurry{
            width: 100%;
            height: 100vh;
            background-color: rgb(0, 0, 56, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .form{
            background-color: white;width: 600px;
            padding: 10px;
            border-radius: 10px;
            box-sizing: border-box;
        }
        input{
            width: 100%;
            height: 40px;
            border-radius: 5px;
            font-size: 20px;
            border: 1px solid #ccc;
        }
        input[type="submit"]{
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="blurry">
    <div class="form">
    <h2>User Login</h2>
    <form action="profile.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <p>Don't have an account? <a href="index.php">Register</p>
        <input type="submit" value="Login">
    </form>
    </div>
    </div>
</body>
</html>
