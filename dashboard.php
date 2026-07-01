<?php

/* Verify if a sesion exist */
/*   and compare its data   */
session_start();

if ( !isset( $_SESSION[ 'user_id' ] ) )
{
    header('Location: login.php');
    exit();
}

/* Loging Out */
if( isset( $_POST[ "logout" ] ) )
{
    header( 'Location : index.php' );
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

        <form method="post" action="">
            <button name="logout" id="btnLogout" type="submit">Log Out</button>
        </form>

    </body>
</html>