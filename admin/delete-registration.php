
<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}


if (!isset($_POST['id']) || !ctype_digit($_POST['id'])) {
    die("Invalid registration ID.");
}

$registration_id = (int) $_POST['id'];

$sql = "DELETE FROM registrations WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $registration_id]);

header("Location: dashboard.php?deleted=1");
exit;

?>
