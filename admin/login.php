
<?php

session_start();

require_once "../config/database.php";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {

        $error = "Please enter username and password.";

    } else {

        $sql = "SELECT * FROM admins WHERE username = :username";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {

            session_regenerate_id(true);

            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];

            header("Location: dashboard.php");
            exit;

        } else {

            $error = "Invalid username or password.";

        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>

    <h1>Admin Login</h1>

    <?php if ($error !== ''): ?>
        <p style="color: red;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form method="POST" action="">

        <div>
            <label for="username">Username:</label>
            <input
                type="text"
                id="username"
                name="username"
                required
            >
        </div>

        <br>

        <div>
            <label for="password">Password:</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <br>

        <button type="submit">Login</button>

    </form>

</body>
</html>
