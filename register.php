<?php
$host = 'localhost';
$db   = 'login';
$user = 'root';
$pass = 'root';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

$errors = [];
$user = [];
$user['username'] = $_POST['username'] ?? '';
$user['password'] = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation
    if (empty($user['username'])) {
        $errors[] = 'Username is required';
    }

    if (empty($user['password'])) {
        $errors[] = 'Password is required';
    } 

    if (empty($errors)) {
       
        $stmt = $pdo->prepare("
            INSERT INTO login
            (username, password)
            VALUES (:username, :password);
        ");

        $stmt->execute([
            'username' => $user['username'],
          'password' => password_hash($user['password'], PASSWORD_DEFAULT),
          
        ]);

}   }


;




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 form-container">
                <form action="" method="POST">
                    <h2>Register</h2>

                  

                    <div class="form-group">
                        <label for="reg_username">Username:</label>
                        <input type="text" class="form-control" id="reg_username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="reg_password">Password:</label>
                        <input type="password" class="form-control" id="reg_password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Register</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
