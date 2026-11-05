
<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("Invalid registration ID.");
}

$registration_id = (int) $_GET['id'];

$sql = "SELECT
            registrations.id,
            registrations.name,
            registrations.email,
            registrations.registered_at,
            events.name AS event_name,
            events.event_date,
            events.description
        FROM registrations
        INNER JOIN events
            ON registrations.event_id = events.id
        WHERE registrations.id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $registration_id]);

$registration = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registration) {
    die("Registration not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Details</title>
</head>
<body>

    <h1>Registration Details</h1>

    <p>
        <strong>Registration ID:</strong>
        <?= (int) $registration['id']; ?>
    </p>

    <p>
        <strong>Name:</strong>
        <?= htmlspecialchars($registration['name'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?= htmlspecialchars($registration['email'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Event:</strong>
        <?= htmlspecialchars($registration['event_name'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Event Date:</strong>
        <?= date('d M Y', strtotime($registration['event_date'])); ?>
    </p>

    <p>
        <strong>Description:</strong>
        <?= htmlspecialchars($registration['description'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Date Registered:</strong>
        <?= date('d M Y H:i', strtotime($registration['registered_at'])); ?>
    </p>

    <a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
