
<?php

require_once "config/database.php";

$sql = "SELECT * FROM events
        WHERE event_date >= CURDATE()
        ORDER BY event_date ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Events</title>
</head>
<body>

    <h1>Upcoming Events</h1>

    <?php if (count($events) > 0): ?>

        <?php foreach ($events as $event): ?>

            <div class="event">

                <h2>
                    <?= htmlspecialchars($event['name'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>

                <p>
                    <strong>Date:</strong>
                    <?= date('d M Y', strtotime($event['event_date'])); ?>
                </p>

                <p>
                    <?= htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8'); ?>
                </p>

                <a href="register.php?event_id=<?= (int) $event['id']; ?>">
                    Register
                </a>

            </div>

            <hr>

        <?php endforeach; ?>

    <?php else: ?>

        <p>No upcoming events available.</p>

    <?php endif; ?>

</body>
</html>
