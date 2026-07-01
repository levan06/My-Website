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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="styles/dashboard.css">
        <link type="text/css" rel="stylesheet" href="styles/media.css">
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

        <title>Dashboard</title>
    </head>

    <body>

        <section class="hero">

            <!-- Header -->
            <header>
            <a href="index.php">
                <img class="logo" src="images/logo.png" alt="Logo">
            </a>

            <!-- Main elements of the header -->
            <div class="pages">
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="">Features</a></li>
                        <li><a href="">Reviews</a></li>
                        <li><a href="">Pricing</a></li>
                        <li><a href="">FAQ</a></li>
                    </ul>
                </nav>

                <form action="logout.php" method="post">
                    <button id="btnLogout" type="submit">
                        <strong>【⏻】Log Out</strong>
                    </button>
                </form>
            </div>
        </header>

        <p class="welcome">
            Welcome <span><?= htmlspecialchars( $_SESSION[ "name" ] ) ?></span> we are happy to have you ! 
            <br>🤗
        </p>
        </section>

        
    </body>
</html>