<?php
// 🧵 Database connection setup
$host = "localhost";
$user = "root";
$password = "anjali6398";
$dbname = "event_db";

// 💻 Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// 🚨 Handle connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/*
📍 localhost = project runs locally on your machine
🌐 0.0.0.0 = used when project should be accessed by any device on the same network
💖 You’re using localhost here because it’s your personal dev setup!
*/
?>
