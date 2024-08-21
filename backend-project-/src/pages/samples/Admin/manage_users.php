







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-custom {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Manage Users</h1>
        <table class="table table-bordered table-striped">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require '../db_connection.php';

                try {
                    $sql = "SELECT id, username, first_name, last_name, email, is_active FROM users WHERE role <> 'admin'";

                    $stmt = $conn->query($sql);

                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $status = $row['is_active'] ? 'Active' : 'Inactive';
                            $action = $row['is_active'] ? 'Deactivate' : 'Activate';
                            $actionColor = $row['is_active'] ? 'btn-danger' : 'btn-success';
                            echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$status}</td>
                                <td>
                                    <form method='POST' action='deactivate_user.php' onsubmit='return confirm(\"Are you sure you want to {$action} this user?\");'>
                                        <input type='hidden' name='user_id' value='{$row['id']}'>
                                        <input type='submit' value='{$action}' class='btn btn-custom {$actionColor}'>
                                    </form>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No users found</td></tr>";
                    }

                } catch (PDOException $e) {
                    echo "<tr><td colspan='7'>Error fetching users: " . $e->getMessage() . "</td></tr>";
                }

                ?>
            </tbody>
        </table>
        <a href="../../../index.html" class="btn btn-secondary">Back to main page</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>
