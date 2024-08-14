<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        form {
            width: 500px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
        }
        input{
            width:100%;
            height: 40px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 20px;

        }
        input[type="file"]{
            border: none !important;
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
    <h2>User Registration</h2>
    <form action="register.php" method="POST" enctype="multipart/form-data">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="surname">Surname:</label><br>
        <input type="text" id="surname" name="surname" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        
        <label for="image1">Images :</label>
        <input type="file" name="files[]" multiple required>
        
   
        
        <input type="submit" value="Register">
    </form>
    </div>
</body>
</html>
