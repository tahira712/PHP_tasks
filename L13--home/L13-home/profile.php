<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            color: white;
            font-size: 40px;
        }
        .blurry{
            width: 100%;
            height: 100vh;
            background-color: rgb(0, 0, 56, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 0 10px;
        }

    </style>
</head>
<body>
    <div class="blurry">
        <?php
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $email = $_POST['email'];

        echo "<h2>  Welcome <br> $email   !<h2/>";
    
        echo "<a style='color: white;display: block; text-decoration: none;font-size: 20px;' href='index.php'>Logout</a>";
      }
    ?>
    </div>
    
</body>
</html>