<?php
session_start();

if (!isset($_SESSION['entries'])) {
    $_SESSION['entries'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['title']) && isset($_POST['content']) && !empty($_POST['title']) && !empty($_POST['content'])) {
        $newEntry = [
            'title' => htmlspecialchars($_POST['title']),
            'content' => htmlspecialchars($_POST['content'])
        ];
        
        $_SESSION['entries'][] = $newEntry;

        $_POST = array();

    } else {
        echo "Please fill out the form completely.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .form form {
            width: 500px;
            height: 300px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        textarea{
            resize: none;
        }
    </style>
</head>
<body>
<div class="form">
    <form action="" method="POST" id="myForm">
        <label for="title">Title: </label>
        <input type="text" name="title" id="title">
        <label for="content">Content: </label>
        <textarea name="content" id="content" cols="30" rows="10"></textarea>
        <input type="submit" id="submitButton" disabled>
    </form>
</div>

<div class="entries">
    <?php
    foreach ($_SESSION['entries'] as $entry) {
        echo "<h1>" . $entry['title'] . "</h1>";
        echo "<p>" . $entry['content'] . "</p>";
    }
    ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let inputField = document.getElementById('title');
        let textarea = document.getElementById('content');
        let button = document.getElementById('submitButton');

        inputField.addEventListener('input', toggleButton);
        textarea.addEventListener('input', toggleButton);

        function toggleButton() {
            let title = inputField.value.trim();
            let content = textarea.value.trim();

            if (title !== '' && content !== '') {
                button.removeAttribute('disabled');
            } else {
                button.setAttribute('disabled', 'disabled');
            }
        }
    });
</script>

</body>
</html>
