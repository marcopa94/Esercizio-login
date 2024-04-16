<?php
session_start();
include __DIR__ . './includes/db.php';

$errors = [];
$user = [];
$user['username'] = $_POST['username'] ?? '';
$user['password'] = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {-
    //-------------------------------------- Validaion-------------------------------------
    if (empty($user['username']) || empty($user['password'])) {
        $errors['credentials'] = 'Username and password are required';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM login WHERE username = :username");

        $stmt->execute(['username' => $user['username']]);
        $user_from_db = $stmt->fetch();

        if ($user_from_db && password_verify($user['password'], $user_from_db['password'])) {
            $_SESSION['user_id'] = $user_from_db['id'];
     
            echo "Logged in";
            exit();
        } else {
            $errors['credentials'] = 'Invalid username or password';
        }
    }
}
?>
<!-- ------------------------------------------------------------------------------- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                    <h2>Login</h2>
                    <?php if (!empty($errors['credentials'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $errors['credentials']; ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="btn btn-primary">Register</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
