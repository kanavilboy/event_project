
<?php

session_start();

require_once "../config/database.php";

// Redirect logged-in admin
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// Handle login form
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

// Page title and header
$pageTitle = "Admin Login";
$basePath = "../";

include "../includes/header.php";

?>

<main>

    <h1>Admin Login</h1>

    <?php if ($error !== ''): ?>

        <p class="error">
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

        <div>
            <label for="password">Password:</label>

            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <button type="submit">Login</button>

    </form>

</main>

<?php include "../includes/footer.php"; ?>
