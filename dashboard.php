<?php

require_once "includes/auth.php";

requireLogin();

$userName  = htmlspecialchars( $_SESSION[ 'name'  ] ?? 'User', ENT_QUOTES, 'UTF-8');
$userEmail = htmlspecialchars( $_SESSION[ 'email' ] ??     '', ENT_QUOTES, 'UTF-8');
$isAdmin   = !empty($_SESSION['is_admin']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/media.css">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">

    <title>My Dashboard</title>
</head>
<body>
    <section class="hero dashboard-hero">
        <header class="site-header">
            <a class="brand" href="index.php">
                <img class="logo" src="images/logo.png" alt="Logo">
            </a>

            <div class="pages">
                <nav aria-label="Main navigation">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a class="active-link" href="dashboard.php">Dashboard</a></li>
                        <?php if ($isAdmin): ?>
                            <li><a href="admin.php">Administration</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <form action="logout.php" method="post">
                    <button id="btnLogout" type="submit">Log out</button>
                </form>
            </div>
        </header>

        <main class="dashboard-content">
            <section class="welcome-card" aria-labelledby="welcome-title">
                <p class="eyebrow">YOUR PERSONAL SPACE</p>
                <h1 id="welcome-title">Welcome back, <span><?= $userName ?></span></h1>
                <p>Your account is connected and ready to use.</p>
            </section>

            <section class="dashboard-grid" aria-label="Account overview">
                <article class="info-card profile-card">
                    <div class="card-icon" aria-hidden="true">&#128100;</div>
                    <div>
                        <p class="card-label">ACCOUNT</p>
                        <h2><?= $userName ?></h2>
                        <p><?= $userEmail ?></p>
                    </div>
                </article>

                <article class="info-card">
                    <div class="card-icon" aria-hidden="true">&#10003;</div>
                    <div>
                        <p class="card-label">ACCOUNT STATUS</p>
                        <h2><span class="status-dot"></span>Active</h2>
                        <p>You have secure access to your space.</p>
                    </div>
                </article>

                <article class="info-card">
                    <div class="card-icon" aria-hidden="true">&#128274;</div>
                    <div>
                        <p class="card-label">SECURITY</p>
                        <h2>Protected session</h2>
                        <p>Remember to log out on shared devices.</p>
                    </div>
                </article>
            </section>
        </main>
    </section>
</body>
</html>
