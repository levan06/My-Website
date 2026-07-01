<?php

/* Verify if the usser isnt already connected */
require_once "includes/auth.php";

requireGuest();


$logErrors = [];

/* Chacking if the inputs are valid */
if (isset($_POST["login"])) 
{
    $email    = trim( $_POST[ "email"    ] ?? "" );
    $password =       $_POST[ "password" ] ?? "";

    // Checking the email
    if ($email === "") 
    {
        $logErrors[] = "Please Enter your email";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $logErrors[] = "Invalid email!";
    }

    // Checking the password
    if( $password === "" )
    {
        $logErrors[] = "Please Enter a password";
    }
}

/*-----------------------------*/
/*   Verify the login infos    */
/*-----------------------------*/
if( isset( $_POST[ "login" ] ) && empty( $logErrors ) )
{
    require_once "includes/db.php";

    // Storing the query
    $sql = "SELECT  * 
                FROM    users 
                WHERE   email = $1";

    /* Checking if the quesry succeeded */
    $result = pg_query_params( $conn, $sql, [ $email ] );

    if (!$result)
    {
        $logErrors[] = "Unable to Verify the account. Please try again soon !";
    }
    // User found in DataBase
    else
    {
        /* Storing the result to verify it later */
        $user = pg_fetch_assoc( $result );

        if ( $user === false )
        {
            $logErrors[] = "Incorrect email or password.";
        }
        // Verify if the password if valid
        elseif ( !password_verify($password, $user["password"]) )
        {
            $logErrors[] = "Incorrect email or password.";
        }
        else
        {
            // Regenerate session ID to prevent session fixation attacks
            session_regenerate_id(true);

            $_SESSION[ 'user_id' ] = $user[ "id"    ];
            $_SESSION[ 'name'    ] = $user[ "name"  ];
            $_SESSION[ 'email'   ] = $user[ "email" ];

            header( 'Location: dashboard.php' );
            exit();
        } 
    }

        pg_close($conn);
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link type="text/css" rel="stylesheet" href="styles/login.css">
        <link type="text/css" rel="stylesheet" href="styles/media.css">
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />

        <title>Login Page</title>
    </head>

    <body>
        <!-- Log in Division -->
        <section class="hero">

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
            </div>
        </header>

        <div class="login">
            <form method="post" action="">
        
                <?php if( isset($_POST["login"]) ): ?>
                    <?php if( !empty( $logErrors ) ): ?>
                        <div class="logErrors">
                            <?php foreach( $logErrors as $error ): ?>
                                <p><?= htmlspecialchars( $error ) ?></p>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                <?php endif ?>
                    
                <label>Log in</label>
                    
                <input name="email"    type="email"    placeholder="Email"     value="<?= htmlspecialchars( $_POST[ "email" ] ?? '' ) ?>">
                <input name="password" type="password" placeholder="Password">
                    
                <datalist id="type" >
                    <option value="Philosophy">
                    <option value="Science">
                    <option value="Logic">
                    <option value="Engineering ">
                </datalist>
                    
                <button name="login" id="btnLogin" type="submit">Log in</button>
            </form>
        </div>
        </section>
    </body>
</html>