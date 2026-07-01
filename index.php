<?php

/* Verify if the usser isnt already connected */
require_once "includes/auth.php";

requireGuest();


/* Managing succefull sing up */
$success = isset( $_GET[ "registered" ] );


$errors = [];

/* Chacking if the inputs are valid */
if ( isset( $_POST["register"] ) ) {

    $name     = trim( $_POST[ "name"     ] ?? "" );
    $email    = trim( $_POST[ "email"    ] ?? "" );
    $password = trim( $_POST[ "password" ] ?? "" );
    $type     = trim( $_POST[ "type"     ] ?? "" );

    if ( $name === "" ) 
    {
        $errors[] = "Please Enter your name";
    }

    if ( $email === "" ) 
    {
        $errors[] = "Please Enter your email";
    } 
    elseif ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) 
    {
        $errors[] = "Invalid email!";
    }
    if( $password === "" )
    {
        $errors[] = "Please Enter a password";
    }
    elseif( strlen( $password ) < 8 )
    {
        $errors[] = "Password must contain at least 8 characters";
    }
}

/*-----------------------------*/
/* Insert the data to dataBase */
/*-----------------------------*/

if ( isset( $_POST[ "register" ] ) && empty( $errors ) )
{

    require_once "includes/db.php";

    /* Checking if the email is not already used */
    $sqlCheckMail = "SELECT 1 from users where email = $1";
    $mailResult   = pg_query_params( $conn, $sqlCheckMail, [$email] );

    // Is the query valid
    if ( !$mailResult )
    {
        $errors[] = "Unable to check if the email exists.";
    }
    // The email is not unique
    elseif( pg_num_rows( $mailResult ) > 0 )
    {
        $errors[] = "Email already exists.";
    }
    // Unique email
    else 
    {
        /* Hashing the user's password */
        $passwordHash = password_hash( $password, PASSWORD_DEFAULT );

        /* Preparing the query */
        $sql = "INSERT INTO users (name, email, password, type)
                    VALUES ($1, $2, $3, $4)";

        /* Checking if insert succeeded */
        $result = pg_query_params(
            $conn,
            $sql,
            [ $name, $email, $passwordHash, $type ]
        );

        if (!$result)
        {
            $errors[] = "Unable to create the account.";
        }
        else
        {
            header( "Location: index.php?registered=1" );
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
        <link type="text/css" rel="stylesheet" href="styles/styles.css">
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico" />
        <title>Abdo's Website</title>
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
                </div>
            </header>

            <!-- Core of the Web Site -->
            <section class="main">
                <div class="main-text">
                    <h1>Don't be afraid to Think !</h1>

                    <p>
                        “The world as we have created it is a process of our thinking. It cannot be changed 
                        without changing our thinking.”
                        <br>― <a href="https://en.wikipedia.org/wiki/Albert_Einstein">Albert Einstein</a>
                    </p>

                    <button id="btnQuote">SEE QUOTES</button>
                </div>

                <!-- Sign Up Division -->
                <div class="main-signUp">
                    <form method="post" action="">

                        <?php if( isset( $_POST[ "register" ] ) ): ?>
                            <?php if( !empty( $errors ) ): ?>
                                <div class="errors">
                                    <?php foreach( $errors as $error ): ?>
                                        <p><?= htmlspecialchars( $error ) ?></p>
                                    <?php endforeach ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if ($success): ?>
                                <div class="valid">
                                    <p>Registration successful! You can now log in.</p>
                                </div>
                        <?php endif; ?>

                        <label>Sign Up For Free</label>

                        <input name="name"     type="text"     placeholder="Full name" value="<?= htmlspecialchars( $_POST[ "name"  ] ?? '' ) ?>">
                        <input name="email"    type="email"    placeholder="Email"     value="<?= htmlspecialchars( $_POST[ "email" ] ?? '' ) ?>">
                        <input name="password" type="password" placeholder="Password">
                        <input name="type"     list="type"     placeholder="Career field"      value="<?= htmlspecialchars( $_POST[ "type"  ] ?? '' ) ?>">

                        <datalist id="type" >
                            <option value="Developer">
                            <option value="DBA">
                            <option value="Network administrator">
                            <option value="Engineering ">
                        </datalist>

                        <button name="register" id="btnRegister" type="submit">Register</button>
                        <a href="login.php">Already have an account ?</a>
                    </form>
                </div>
            </section>
        </section>
    </body>
</html>