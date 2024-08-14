<?php
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
    header('location:main.php');
}

require "config.php";
require "helper.php";


if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = post("email");
    $password = post("password");

    $sql = "SELECT * FROM users WHERE email = ?";

    $loginQuery = $connection->prepare($sql);
    $loginQuery->execute([$email]);
    $user = $loginQuery->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];

        header('Location: main.php');
    }
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h1>Login Form</h1>
            <form action="" method="post" class="form-control mt-5">

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>


                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">Log in</button>
                    <a style="text-decoration: none;color: black" href="register.php">If you dont have user, go
                        register</a>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>
