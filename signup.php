<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new user
    public function create($fullname, $email, $username, $password, $genderId, $roleId) {
        $query = "INSERT INTO " . $this->table_name . " (fullname, email, username, password, genderId, roleId, created, updated) 
                  VALUES (:fullname, :email, :username, :password, :genderId, :roleId, NOW(), NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT)); // Hashing the password
        $stmt->bindParam(':genderId', $genderId);
        $stmt->bindParam(':roleId', $roleId);

        return $stmt->execute();
    }
}

// Database connection
class Database {
    private $host = "localhost";
    private $db_name = "your_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}

// Processing form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->create($_POST['fullname'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['genderId'], $_POST['roleId']);
    
    echo "User registered successfully!";
}
?>
