
<!-- 4)Form-u POST edən zaman formun validasiyasını yazın  -->
<?php
$errors=[];
$form_data = [
    'title' => '',
    'description' => '',
    'image'=> ''
];

if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
    $errors['image'] = 'Image is required.';
} elseif ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errors['image'] = 'Error uploading image.';
} else {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowed_types)) {
        $errors['image'] = 'Only JPG, PNG, and GIF are allowed.';
    } else {
        $form_data['image'] = $_FILES['image']['name'];
    }
}
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(empty($_POST['title'])) {
        $errors['title'] = 'Title is required';
    } else {
        $form_data['title'] = $_POST['title'];
    }

    if(empty($_POST['description'])) {
        $errors['description'] = 'Description is required';
    } else {
        $form_data['description'] = $_POST['description'];
    }

    if(empty($_POST['image'])) {
        $errors['image'] = 'Image is required';
    } else {
        $form_data['image'] = $_POST['image'];
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
        .error{
            color:red
        }
        </style>
</head>
<body>
    <h1>Form with Validation</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($form_data['title'] ?? ''); ?>">
        <?php if (isset($errors['title'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['title']); ?></span>
        <?php endif; ?><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($form_data['description'] ?? ''); ?></textarea>
        <?php if (isset($errors['description'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['description']); ?></span>
        <?php endif; ?><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*">
        <?php if (isset($errors['image'])): ?>
            <span class="error"><?php echo htmlspecialchars($errors['image']); ?></span>
        <?php endif; ?><br>

        <input type="submit" value="Submit">
    </form>
    <?php if (isset($_SESSION['form_data'])): ?>
        <h2>Form Submitted Data</h2>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['description']); ?></p>
        <p><strong>Image:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['image']); ?></p>
        <?php if (!empty($_SESSION['form_data']['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($_SESSION['form_data']['image']); ?>" alt="Uploaded Image" style="max-width: 200px;">
        <?php endif; ?>
        <?php unset($_SESSION['form_data']); ?>
    <?php endif; ?>
</body>
</html>