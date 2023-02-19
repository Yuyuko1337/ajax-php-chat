<?php
// db
$servername = htmlspecialchars("localhost");
$dbname = htmlspecialchars("chat");
$username = htmlspecialchars("root");
$password = htmlspecialchars("");

// domain
$domain = $_SERVER['HTTP_HOST'];
?>

<?php
// connect to db
$base = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// check table
$stmt = $base->prepare("SHOW TABLES LIKE 'users'");
$stmt->execute();
?>
