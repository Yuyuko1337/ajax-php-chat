<?php
include("db.php");
?>

<?php error_reporting(0); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup DB</title>
    <link rel="stylesheet" href="../style.css">
  </head>
<body>
<?php
try{
    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connect_check = true;
        echo '<p style="color: white;">Connected successfully !</p>';
          }
          catch(PDOException $exe){
            echo '<p style="color: white;">Connection failed !</p>';
			      echo '<p>Table install failed !</p>';
    }
?>

<?php
try{	
	$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            $base->exec("CREATE TABLE users(
                        Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        Username VARCHAR(30) NOT NULL,
                        Token VARCHAR(64) NOT NULL,
                        Activity VARCHAR(64) NOT NULL,
                        Color VARCHAR(40) NOT NULL)
                       ");
            $base->exec("CREATE TABLE messages(
                        Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        Postday VARCHAR(80) NOT NULL,
                        Hours VARCHAR(80) NOT NULL,
                        Content TEXT NOT NULL,
                        Authorcl VARCHAR(40) NOT NULL,
                        Author VARCHAR(255) NOT NULL)
                        ");
                echo '<p style="color: white;">Table installed successfully !</p>';
                echo '<a style="text-decoration:none; color: #b994cb; padding: 5px;" href="'. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .'"> ---> '. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .' <--- </a>';
            }
            catch(PDOException $exe){
               echo '<p style="color: white;">Table install failed or already exist !</p>';
               echo '<a style="text-decoration:none; color: #b994cb; padding: 5px;" href="'. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .'"> ---> '. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .' <--- </a>';
            }
?>
	</body>
</html>