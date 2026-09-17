<?php

$host = getenv("PGHOST") ?: '127.0.0.1'; // Uses '127.0.0.1' if getenv returns false or empty;
$port = getenv("PGPORT") ?: '5432';
$db   = getenv("PGDATABASE");
$user = getenv("PGUSER");
$pass = getenv("PGPASSWORD");

$conn = pg_connect(
    "host=$host port=$port dbname=$db user=$user password=$pass"
);

if (!$conn)
{
    die("Unable to connect to the database.");
}
