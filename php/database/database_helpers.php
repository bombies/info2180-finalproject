<?php
require_once '../../env.php';

$host = $_ENV['DATABASE_HOST']; // Had to specify port due to conflicts with existing databases on my host machine
$username = $_ENV['DATABASE_USERNAME'];
$password = $_ENV['DATABASE_PASSWORD'];
$dbname = $_ENV['DATABASE_NAME'];

$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
