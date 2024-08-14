<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .form {
            width: 500px;
            display: flex;
            flex-direction: column;
            padding: 25px;
            gap: 20px;     
            background-color: rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 8px 0 rgba(255, 255, 255, 0.9), 0 6px 20px 0 rgba(255, 255, 255, 0.29);
            border-radius: 10px;
            margin: 100px auto;
        }
        .blurry {
            width: 100%;
            height: 100vh;
            background-color: rgb(0, 0, 56, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .error {
            border: 1px solid red;
        }
        body {
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("log.avif");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }
        input, button {
            width: 100%;
            height: 50px;
            padding: 0 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            outline: none;
            font-size: 16px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            background-color: #2196f3;
            color: #fff;
            cursor: pointer;
            border: none;
        }
        input::placeholder {
            font-size: 15px;
        }
        input[type="submit"]:disabled {
            background-color: rgb(30, 25, 44, 0.5);
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="blurry">
        <div class="form">
            <form action="profile.php" method="POST" id="myForm">
                <h1>Login</h1>
                <input type="text" name="name" id="name" placeholder="Name" required>
                <span id="error1" style="color: red;"></span>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <span id="error2" style="color: red;"></span>
                <input type="submit" id="submitButton" disabled>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let nameField = document.getElementById('name');
            let emailField = document.getElementById('email');
            let button = document.getElementById('submitButton');
            let error1 = document.getElementById('error1');
            let error2 = document.getElementById('error2');

            function toggleButton() {
                let name = nameField.value.trim();
                let email = emailField.value.trim();
                let isValid = true;

                if (name === '') {
                    error1.innerText = "Please enter your name";
                    nameField.classList.add('error');
                    isValid = false;
                } else {
                    error1.innerText = "";
                    nameField.classList.remove('error');
                }

                if (email === '') {
                    error2.innerText = "Please enter your email";
                    emailField.classList.add('error');
                    isValid = false;
                } else {
                    error2.innerText = "";
                    emailField.classList.remove('error');
                }

                if (isValid) {
                    button.removeAttribute('disabled');
                } else {
                    button.setAttribute('disabled', 'disabled');
                }
            }

            nameField.addEventListener('input', toggleButton);
            emailField.addEventListener('input', toggleButton);

            document.getElementById('myForm').addEventListener('submit', function(event) {
               
              window.location.href = "profile.php";
            });
        });
    </script>

</body>
</html>
