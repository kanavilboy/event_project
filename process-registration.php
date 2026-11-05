<?php

require_once "config/database.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$event_id = $_POST['event_id'] ?? '';

if ($name === '') {
    die("Name is required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address.");
}

if (!ctype_digit((string) $event_id) || (int) $event_id <= 0) {
    die("Invalid event selection.");
}

$event_id = (int) $event_id;

$check_sql = "SELECT id FROM events
              WHERE id = :event_id
              AND event_date >= CURDATE()";

$check_stmt = $pdo->prepare($check_sql);
$check_stmt->execute(['event_id' => $event_id]);

if (!$check_stmt->fetch()) {
    die("Event not found or registration is unavailable.");
}

$insert_sql = "INSERT INTO registrations
               (event_id, name, email)
               VALUES (:event_id, :name, :email)";

$insert_stmt = $pdo->prepare($insert_sql);

$insert_stmt->execute([
    'event_id' => $event_id,
    'name' => $name,
    'email' => $email
]);

session_start();

$_SESSION['registration_id'] = $pdo->lastInsertId();

header("Location: success.php");
exit;

?>
