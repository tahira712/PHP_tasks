<?php

class Database {
    private $pdo;
    private $table;

    public function __construct($dsn, $user, $password, $table) {
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->table = $table;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute(array_values($data));
            return "New record created successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function selectAll() {
        $sql = "SELECT * FROM $this->table";
        
        $stmt = $this->pdo->query($sql);

        try {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([$id]);
            return "Record deleted successfully";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function __destruct() {
        $this->pdo = null;
    }
}

$dsn = 'mysql:host=localhost;dbname=oop;charset=utf8';
$user = 'root';
$password = ''; 
$table = 'db';

$db = new Database($dsn, $user, $password, $table);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['insert'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $db->insert(['name' => $name, 'email' => $email]);
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $message = $db->delete($id);
    }
}

$records = $db->selectAll();
?>

