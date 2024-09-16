<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT userId, fullname, email, username, genderId, roleId, created, updated FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$users = $user->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="my-4">Registered Users</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Username</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Created</th>
                    <th>Updated</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['userId']; ?></td>
                    <td><?php echo $row['fullname']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['genderId'] == 1 ? 'Male' : 'Female'; ?></td>
                    <td><?php echo $row['roleId'] == 1 ? 'Admin' : 'User'; ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td><?php echo $row['updated']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
