
<?php
$basePath = $basePath ?? '';
$pageTitle = $pageTitle ?? 'Event Registration System';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle); ?></title>

    <link rel="stylesheet" href="<?= $basePath; ?>assets/css/style.css">
</head>

<body>

    <div class="container">

        <header>
            <nav>
                <a href="<?= $basePath; ?>index.php">Home</a>
                <a href="<?= $basePath; ?>admin/login.php">Admin Login</a>
            </nav>
        </header>

        <hr>
