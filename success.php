
<?php

session_start();

require_once "config/database.php";

if (!isset($_SESSION['registration_id'])) {
    die("No registration found. Please register for an event first.");
}

$registration_id = (int) $_SESSION['registration_id'];

$sql = "SELECT registrations.name, registrations.email,
               events.name AS event_name, events.event_date
        FROM registrations
        INNER JOIN events
        ON registrations.event_id = events.id
        WHERE registrations.id = :registration_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['registration_id' => $registration_id]);

$registration = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$registration) {
    die("Registration details not found.");
}

unset($_SESSION['registration_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
</head>
<body>

    <h1>Registration Successful!</h1>

    <p>
        Thank you,
        <strong>
            <?= htmlspecialchars($registration['name'], ENT_QUOTES, 'UTF-8'); ?>
        </strong>!
    </p>

    <p>Your registration has been completed successfully.</p>

    <h2>Registration Details</h2>

    <p>
        <strong>Event:</strong>
        <?= htmlspecialchars($registration['event_name'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Date:</strong>
        <?= date('d M Y', strtotime($registration['event_date'])); ?>
    </p>

    <p>
        <strong>Name:</strong>
        <?= htmlspecialchars($registration['name'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?= htmlspecialchars($registration['email'], ENT_QUOTES, 'UTF-8'); ?>
    </p>

    <a href="index.php">Back to Home</a>

</body>
</html>
