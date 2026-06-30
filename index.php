<?php

$errors = [];

/* Chacking if the inputs are valid */
if (isset($_POST["register"])) {

    $name     = trim( $_POST[ "name"     ] ?? "" );
    $email    = trim( $_POST[ "email"    ] ?? "" );
    $password = trim( $_POST[ "password" ] ?? "" );
    $type     = trim( $_POST[ "type"     ] ?? "" );

    if ($name === "") 
    {
        $errors[] = "Please Enter your name";
    }

    if ($email === "") 
    {
        $errors[] = "Please Enter your email";
    } 
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        $errors[] = "Invalid email!";
    }
    if( $password === "" )
    {
        $errors[] = "Please Enter a password";
    }
    else if( strlen( $password ) < 8 )
    {
        $errors[] = "Password must contain at least 8 characters";
    }
}

/*-----------------------------*/
/* Insert the data to dataBase */
/*-----------------------------*/

if ( isset($_POST["register"]) && empty($errors) )
{

    /* Trying to connect to the DataBase */
    $host        = "host=localhost";
    $port        = "port=5432";
    $dbname      = "dbname=myWebsite";
    $credentials = "user=postgres password=Absoramo@2025";

    $conn = pg_connect( "$host $port $dbname $credentials"  );

    if (!$conn)
    {
        $errors[] = "Unable to connect to the database.";
    }
    else // Connection valid
    {
        /* Checking if the email is not already used */
        $sqlCheckMail = "SELECT 1 from users where email = $1";
        $mailResult   = pg_query_params( $conn, $sqlCheckMail, [$email] );

        // Is the query valid
        if (!$mailResult)
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
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            /* Preparing the query */
            $sql = "INSERT INTO users (name, email, password, type)
                    VALUES ($1, $2, $3, $4)";

            /* Checking if insert succeeded */
            $result = pg_query_params(
                $conn,
                $sql,
                [$name, $email, $passwordHash, $type]
            );

            if (!$result) {
                $errors[] = "Unable to create the account.";
            }
        }

        pg_close($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link type="text/css" rel="stylesheet" href="styles.css">
        <title>Landing</title>
    </head>

    <body>
        
        <section class="hero">

            <!-- Header -->
            <header>
                <img src="images/logo.png" alt="Logo">

                <!-- Main elements of the header -->
                <div class="pages">
                    <nav>
                        <ul>
                            <li><a href="">Home</a></li>
                            <li><a href="">Features</a></li>
                            <li><a href="">Reviews</a></li>
                            <li><a href="">Pricing</a></li>
                            <li><a href="">FAQ</a></li>
                        </ul>
                    </nav>

                    <button id="btnStart">Get Started</button>
                </div>
            </header>

            <!-- Core of the Web Site -->
            <section class="main">
                <div class="main-text">
                    <h3>Fly makes you faster</h3>

                    <p>
                        New free template bu <a href="https://uicookies.com/">uicookies.com</a>. For more templates visit the <a href="https://www.wikipedia.org/">site</a>. Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                    </p>

                    <button id="btnPricing">SEE PRICING</button>
                </div>

                <!-- Sign Up Division -->
                <div class="main-signUp">
                    <form method="post" action="">

                        <?php if( isset($_POST["register"]) ): ?>
                            <?php if( !empty( $errors ) ): ?>
                                <div class="errors">
                                    <?php foreach( $errors as $error ): ?>
                                        <p><?= htmlspecialchars( $error ) ?></p>
                                    <?php endforeach ?>
                                </div>

                            <?php else: ?>
                                <div class="valid">
                                    <p><?= htmlspecialchars( "Registration Successful! Welcome to Abdo's Website." ) ?></p>
                                </div>
                            <?php endif ?>
                        <?php endif ?>

                        <label>Sign Up For Free</label>

                        <input name="name"     type="text"     placeholder="Full name" value="<?= htmlspecialchars( $_POST[ "name"  ] ?? '' ) ?>">
                        <input name="email"    type="email"    placeholder="Email"     value="<?= htmlspecialchars( $_POST[ "email" ] ?? '' ) ?>">
                        <input name="password" type="password" placeholder="Password">
                        <input name="type"     list="type"     placeholder="Type"      value="<?= htmlspecialchars( $_POST[ "type"  ] ?? '' ) ?>">

                        <datalist id="type" >
                            <option value="BMW">
                            <option value="Bentley">
                            <option value="Mercedes">
                            <option value="Audi">
                            <option value="Volkswagen">
                        </datalist>

                        <button name="register" id="btnRegister" type="submit">Register</button>
                    </form>
                </div>
            </section>
        </section>
    </body>
</html>