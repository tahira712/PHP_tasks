<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100%;
            height: 100%;
            background-image: url("log.avif");
            background-repeat: no-repeat;
            background-size: cover;
            font-family: 'Poppins', sans-serif;
        }

        .blurry {
            width: 100%;
            height: 100vh;
            background-color: rgb(0, 0, 56, 0.7);
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        h2,
        h3 {
            color: white;
        }

        .center {
            width: 450px;
            height: 100px;
        }

        h4 {
            cursor: pointer;
            color: red;
            font-size: 20px;
        }
    </style>
</head>

<body>

    <div class="blurry">
        <h1 style="color: white;">Profile</h1>

        <div class="center">
            <h2>Welcome <?php echo $_POST['name']; ?></h2>
            <h3>Name: <?php echo $_POST['name']; ?></h3>
            <h3>Email: <?php echo $_POST['email']; ?></h3>



        </div>
        <h4>Logout</h4>
    </div>
    <script>
        let logout = document.querySelector("h4");
        logout.addEventListener("click", () => {
            window.location.href = "index.php";
        })
    </script>
</body>

</html>