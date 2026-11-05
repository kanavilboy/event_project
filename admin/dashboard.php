
<?php

session_start();

require_once "../config/database.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT
            registrations.id,
            registrations.name,
            registrations.email,
            registrations.registered_at,
            events.name AS event_name,
            events.event_date
        FROM registrations
        INNER JOIN events
            ON registrations.event_id = events.id
        ORDER BY registrations.registered_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();

$registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="container">

        <h1>Admin Dashboard</h1>

        <p>
            Welcome,
            <?= htmlspecialchars($_SESSION['admin_username'], ENT_QUOTES, 'UTF-8'); ?>!
        </p>

        <p>
            Total Registrations: <strong><?= count($registrations); ?></strong>
        </p>

        <hr>

        <h2>All Event Registrations</h2>

        <?php if (count($registrations) > 0): ?>

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Event</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php foreach ($registrations as $registration): ?>

                        <tr>
                            <td><?= (int) $registration['id']; ?></td>

                            <td>
                                <?= htmlspecialchars($registration['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($registration['email'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($registration['event_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>

                            <td>
                                <?= date('d M Y H:i', strtotime($registration['registered_at'])); ?>
                            </td>

                            <td>
                                <a href="view-registration.php?id=<?= (int) $registration['id']; ?>">
                                    View
                                </a>

                                <form action="delete-registration.php" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this registration?');">

                                    <input type="hidden" name="id"
                                        value="<?= (int) $registration['id']; ?>">

                                    <button type="submit">Delete</button>

                                </form>
                            </td>
                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <p>No registrations found.</p>

        <?php endif; ?>

        <br>

        <a href="logout.php">Logout</a>

    </div>

</body>
</html>
