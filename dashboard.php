<?php

/* Verify if a sesion exist */
/*   and compare its data   */
require_once "includes/auth.php";

requireLogin();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link type="text/css" rel="stylesheet" href="styles/dashboard.css">
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
    </head>

    <body>

        <p>
            <?= "Welcome " . htmlspecialchars( $_SESSION[ "name" ] ) . 
                " your mail is : " . htmlspecialchars( $_SESSION[ "email" ] ); 
            ?>
        </p>

        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>

    </body>
</html>