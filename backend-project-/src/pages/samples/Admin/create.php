<?php
include './create-code.php'
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="circle">
                    <img src="<?php echo htmlspecialchars($base_image_path . ($user['profile_image'] ?: 'default.jpg')); ?>"
                        alt="Profile Image">
                </div>
                <div class="ml-3">
                    <h5><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h5>
                    <p class="mb-0"><?php echo htmlspecialchars($user['birth_date']); ?></p>
                </div>
                <a href="../user/user_pages/edit_profile.php" class="btn btn-secondary ml-auto">Edit</a>
            </div>
        </div>
    </nav>


    <div class="container mt-5">
        <h1 class="mb-4">Create New Category</h1>
        <?php if (isset($success_message))
            echo $success_message; ?>
        <?php if (isset($error_message))
            echo $error_message; ?>
        <form action="create.php" method="POST">
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" id="category_name" name="category_name" required>
            </div>
            <button type="submit" name="create_category" class="btn btn-primary">Create Category</button>
        </form>

        <div class="container">
            <h2 class="my-4">Daily Created Count</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Created Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dailyCounts as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2 class="my-4">Monthly Created Count</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Created Count</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthlyCounts as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['month']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

      
             




                    <div class="container mt-5">
                        <h2>Categories</h2>
                        <?php if (isset($error_message))
                            echo $error_message; ?>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($category['id']); ?></td>
                                        <td><?php echo htmlspecialchars($category['name']); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                                data-target="#updateModal<?php echo $category['id']; ?>">Edit</button>
                                            <form action="create.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="category_id"
                                                    value="<?php echo $category['id']; ?>">
                                                <button type="submit" name="delete_category"
                                                    class="btn btn-danger btn-sm">Delete</button>
                                            </form>

                                            <div class="modal fade" id="updateModal<?php echo $category['id']; ?>"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="updateModalLabel<?php echo $category['id']; ?>"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="updateModalLabel<?php echo $category['id']; ?>">Update
                                                                Category</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="create.php" method="POST">
                                                                <input type="hidden" name="category_id"
                                                                    value="<?php echo $category['id']; ?>">
                                                                <div class="form-group">
                                                                    <label for="category_name">Category Name</label>
                                                                    <input type="text" class="form-control"
                                                                        id="category_name" name="category_name"
                                                                        value="<?php echo htmlspecialchars($category['name']); ?>"
                                                                        required>
                                                                </div>
                                                                <button type="submit" name="update_category"
                                                                    class="btn btn-primary">Update Category</button>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
               
        
        </div>

    </div>






    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>

</html>
<?php
include './publish.php';
include './manage_users.php';