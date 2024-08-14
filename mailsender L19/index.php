<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sender</title>
</head>
<body>
    <form action="send.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required><br>
        
        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="4" required></textarea><br>
        
        <button type="submit" name="send">Send</button>
    </form>
</body>
</html>
