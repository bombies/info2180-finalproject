<?php
$host = 'localhost:3306'; // Had to specify port due to conflicts with existing databases on my host machine
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';
$db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

?>
