<?php
session_start();
if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != null){
    header('location:main.php');
}


#include "config.php";
# Exception var, xeta  var.
require "config.php";
require "helper.php";
#Fatal error, bundan asagi kod dayanir.

#include_once  bununla her hansi yalniz bir defe import elemek mumkundur.
#require_once  bununla her hansi yalniz bir defe import elemek mumkundur.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = post('name');
    $email = post('email');
    $password = post('password');
    $password_confirmation = post('password_confirmation');

    if ($password == $password_confirmation) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        //123456789
        $sql = "INSERT INTO users (	name,email,password) VALUE (?,?,?)";
//        $sql = "INSERT INTO users (name,email,pwd) VALUE (:name,:email,:pwd)";

        try {
            $loginQuery = $connection->prepare($sql);

            $check = $loginQuery->execute([
                $name,
                $email,
                $password
            ]);
            //        $loginQuery->execute([
//            'name'=> $name,
//            'email'=> $email,
//            'pwd'=> $password
//        ]);

            if ($check) {
                header("location: login.php");
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] === 1062) {
                echo "Email already exists";
            } else {
                echo $e->getMessage();
            }
        }
    } else {
        echo 'Sifreler bir biri ile uymur';
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
    <title>Register Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h1>Register Form</h1>
            <form action="" method="post" class="form-control mt-5">
                <div class="mb-3">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input class="form-control" type="password" name="password_confirmation" required>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit">Register</button>
                    <a style="text-decoration: none;color: black" href="login.php">If you have user, go login</a>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>

