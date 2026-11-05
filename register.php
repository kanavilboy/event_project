<?php

require_once "config/database.php";

if (!isset($_GET['event_id']) || !ctype_digit($_GET['event_id'])) {
    die("Invalid event selection.");
}

$event_id = (int) $_GET['event_id'];

$sql = "SELECT * FROM events
        WHERE id = :event_id
        AND event_date >= CURDATE()";

$stmt = $pdo->prepare($sql);
$stmt->execute(['event_id' => $event_id]);

$event = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$event) {
    die("Event not found or registration is unavailable.");
}
include "includes/header.php";
?>


<main>
    <h1>Event Registration</h1>

        <h2>
            <?= htmlspecialchars($event['name'], ENT_QUOTES, 'UTF-8'); ?>
        </h2>

        <p>
            Date:
            <?= date('d M Y', strtotime($event['event_date'])); ?>
        </p>

        <p>
            <?= htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8'); ?>
        </p>

        <hr>

        <form action="process-registration.php" method="POST">

            <input
                type="hidden"
                name="event_id"
                value="<?= (int) $event['id']; ?>"
            >

            <div>
                <label for="name">Your Name:</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    required
                >
            </div>

            <br>

            <div>
                <label for="email">Email Address:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    required
                >
            </div>

            <br>

            <button type="submit">Submit Registration</button>

        </form>
</main>

<?php include "includes/footer.php"; ?>