<?php

$server = "";
$user = "";
$pass = "";
$db = "";

$link = new mysqli($server, $user, $pass, $db, 3306);

if ($link->connect_error)
    die("Database connection failed: " . $link->connect_error);

?>