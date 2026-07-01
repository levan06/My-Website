<?php

/* Verify if a sesion exist */
/*   and compare its data   */
session_start();

if ( !isset( $_SESSION[ 'user_id' ] ) )
{
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link type="text/css" rel="stylesheet" href="dashboard.css">
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