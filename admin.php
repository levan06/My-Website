<?php

require_once "includes/auth.php";

requireLogin();

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403);
    die("Access Denied: You are not an admin.");
}

$users = [];
$totalUsers = 0;
$adminUsers = 0;
$databaseError = false;

require_once "includes/db.php";

$result = pg_query(
    $conn,
    "SELECT id, name, email, type, is_admin FROM users ORDER BY id DESC"
);

if ($result) {
    while ($user = pg_fetch_assoc($result)) {
        $users[] = $user;
        $totalUsers++;

        if ($user['is_admin'] === 't') {
            $adminUsers++;
        }
    }

    pg_free_result($result);
} else {
    $databaseError = true;
}

pg_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="styles/dashboard.css">
    <link rel="stylesheet" href="styles/media.css">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">

    <title>Administration</title>
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
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <li><a class="active-link" href="admin.php">Administration</a></li>
                    </ul>
                </nav>

                <form action="logout.php" method="post">
                    <button id="btnLogout" type="submit">Log out</button>
                </form>
            </div>
        </header>

        <main class="dashboard-content admin-content">
            <section class="welcome-card" aria-labelledby="admin-title">
                <p class="eyebrow">ADMINISTRATION</p>
                <h1 id="admin-title">User management</h1>
                <p>View accounts registered on the platform and their access level.</p>
            </section>

            <section class="stats-grid" aria-label="User statistics">
                <article class="stat-card">
                    <p>Total users</p>
                    <strong><?= $totalUsers ?></strong>
                    <span>Registered accounts</span>
                </article>

                <article class="stat-card">
                    <p>Administrators</p>
                    <strong><?= $adminUsers ?></strong>
                    <span>Accounts with admin access</span>
                </article>

                <article class="stat-card">
                    <p>Standard users</p>
                    <strong><?= $totalUsers - $adminUsers ?></strong>
                    <span>Member accounts</span>
                </article>
            </section>

            <section class="users-panel" aria-labelledby="users-title">
                <div class="panel-heading">
                    <div>
                        <p class="eyebrow">DIRECTORY</p>
                        <h2 id="users-title">Registered users</h2>
                    </div>

                    <span class="user-count">
                        <?= $totalUsers ?> user<?= $totalUsers === 1 ? '' : 's' ?>
                    </span>
                </div>

                <?php if ($databaseError): ?>
                    <p class="empty-state">Unable to load the user list at the moment.</p>
                <?php elseif (empty($users)): ?>
                    <p class="empty-state">No users are registered yet.</p>
                <?php else: ?>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Account type</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <?php $isUserAdmin = $user['is_admin'] === 't'; ?>
                                    <tr>
                                        <td><strong><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></strong></td>
                                        <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['type'] ?? 'Not specified', ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <span class="role-badge <?= $isUserAdmin ? 'role-admin' : 'role-user' ?>">
                                                <?= $isUserAdmin ? 'Administrator' : 'User' ?>
                                            </span>
                                        </td>
                                        <td><span class="status-badge"><i></i>Active</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </section>
</body>
</html>
