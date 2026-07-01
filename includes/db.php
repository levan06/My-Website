<?php

$host = getenv("PGHOST");
$port = getenv("PGPORT");
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