<?php

session_start();

function requireGuest()
{
    if ( isset( $_SESSION[ "user_id" ] ) )
    {
        header( "Location: dashboard.php" );
        exit();
    }
}

function requireLogin()
{
    if ( !isset( $_SESSION[ "user_id" ] ) )
    {
        header( "Location: login.php" );
        exit();
    }
}