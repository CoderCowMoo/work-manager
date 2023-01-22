<?php
// the .env.php file at project root contains constants for the database connection
// separate file to keep it out of the repo
require __DIR__ . '/../.env.php';
$conn = new mysqli($hostname, $user, $password, $database);