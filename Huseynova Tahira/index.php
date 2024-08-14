<?php

$employees = [
    [
        "id" => 1,
        "name" => "John Doe",
        "department" => "IT",
        "email" => "john@example.com",
        "salary" => 60000,
        "universities" => ["MIT", "Harvard"],
        "family" => [
            "wife" => "Jane Doe",
            "has_children" => true,
            "children" => [
                ["name" => "Chris Doe", "age" => 5],
                ["name" => "Anna Doe", "age" => 3]
            ]
        ]
    ],
    [
        "id" => 2,
        "name" => "Jane Smith",
        "department" => "HR",
        "email" => "jane@example.com",
        "salary" => 55000,
        "universities" => ["Yale", "Princeton"],
        "family" => [
            "wife" => "John Smith",
            "has_children" => false,
            "children" => []
        ]
    ],
    [
        "id" => 3,
        "name" => "Mark Brown",
        "department" => "Finance",
        "email" => "mark@example.com",
        "salary" => 50000,
        "universities" => ["Stanford", "Berkeley"],
        "family" => [
            "wife" => "Lucy Brown",
            "has_children" => true,
            "children" => [
                ["name" => "Tom Brown", "age" => 7]
            ]
        ]
    ],
    [
        "id" => 4,
        "name" => "Emily Davis",
        "department" => "Marketing",
        "email" => "emily@example.com",
        "salary" => 65000,
        "universities" => ["UCLA", "USC"],
        "family" => [
            "wife" => "Peter Davis",
            "has_children" => false,
            "children" => []
        ]
    ],
    [
        "id" => 5,
        "name" => "Michael Johnson",
        "department" => "IT",
        "email" => "michael@example.com",
        "salary" => 70000,
        "universities" => ["Caltech", "Oxford"],
        "family" => [
            "wife" => "Laura Johnson",
            "has_children" => true,
            "children" => [
                ["name" => "Sarah Johnson", "age" => 2]
            ]
        ]
    ]
];
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Email</th>
                <th>Salary</th>
                <th>Universities</th>
                <th>Family</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td> <?php echo $employee["id"] ?></td>
                    <td> <?php echo $employee["name"] ?></td>
                    <td> <?php echo $employee["department"] ?></td>
                    <td> <?php echo $employee["email"] ?></td>
                    <td> <?php echo $employee["salary"] ?></td>
                    <td> <?php echo implode(", ", $employee["universities"]) ?></td>
                    <td> <?php if ($employee['family']['has_children']): ?>
                        <strong>Wife:</strong> <?php echo htmlspecialchars($employee['family']['wife']); ?><br>
                        <strong>Children:</strong>
                        <ul>
                            <?php foreach ($employee['family']['children'] as $child): ?>
                                <li><?php echo htmlspecialchars($child['name']) . " (" . htmlspecialchars($child['age']) . " years old)"; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <?php echo htmlspecialchars($employee['family']['wife']); ?> (No children)
                    <?php endif; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>







<!-- 2 -->
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['form_data'] = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'image' => $_FILES['image']['name'] ?? ''
    ];

 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        form{
            display: flex;
            flex-direction: column;
            width: 600px;
            & textarea{
                resize: none;
            }
            & input{
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <h1>Form Submission</h1>
    <form action="" method="post">
        <label for="title">Title :</label>
        <input type="text" id="title" name="title">
        <label for="description">Description :</label>
        <textarea name="description" id="description" rows="10"></textarea>
        <label for="file">Your file:</label>
        <input type="file" id="file" name="image" accept="image/*" required>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php if (isset($_SESSION['form_data'])): ?>
        <h2>Form Submitted Data</h2>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['title']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['description']); ?></p>
        <p><strong>Image:</strong> <?php echo htmlspecialchars($_SESSION['form_data']['image']); ?></p>
        <?php if (!empty($_SESSION['form_data']['image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($_SESSION['form_data']['image']); ?>" alt="Uploaded Image" style="max-width: 200px;">
        <?php endif; ?>
    <?php endif; ?>


    <!-- 3 -->
    <!-- 3)POST və GET nədir?Fərqləri nədir?

GET serverdən informasiya əldə etmək,POST isə informasiya göndərmək üçün istifadə olunur,
GET ilə göndərilə bilən informasiya limitlidir 2000 simvoldan
çox ola bilməz,POST methodunda isə belə bir məhdudiyyət yoxdur
POST ilə göndərilən informasiya təhlükəsizdir ,xaricdən müdaxilə etmək daha çətindir 
GET ilə göndərilən informasiyaya URL-dən müdaxilə etmək daha asandır .
Kateqoriyadakı kimi seçimlərdə GET metodu daha çox istifadə olunur

