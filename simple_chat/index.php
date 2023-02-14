<?php
include('admin/db.php');
?>

<?php
if ($stmt->rowCount() === 0) {
    // db has not been setup
    echo '<body style="background-color:black">
    <title>Please setup the DB</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="../../css/style.css">
    <p style="color: white;">please setup db ===>
    <a style="text-decoration:none; color: #b994cb; padding: 5px;" href="'. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .'admin">'. htmlspecialchars($domain, ENT_QUOTES, 'UTF-8') .'admin</a>
    ';
} else {
?>

<?php
if (isset($_COOKIE['user_data'])) {
    $user_data = json_decode($_COOKIE['user_data'], true);
    $username = $user_data['username'];
    $user_token = $user_data['token'];
    $user_cl = $user_data['usercolor'];
  
    // find user in the db
    $stmt = $base->prepare("SELECT * FROM users WHERE Token=?");
    $stmt->execute([$user_token]);
    if($stmt->rowCount() === 1) {
      $user = $stmt->fetch();
      // log the user
      $_SESSION['connected'] = htmlspecialchars($user['Username']);
      $_SESSION['Id'] = htmlspecialchars($user['Id']);
      $_SESSION['color'] = htmlspecialchars($user['Color']);
      header('Location: chat.php');
    }
  }
?>

<?php

// random colors for users
$colors = array("#f00", "#8b00ff", "#ff00bf", "#0010ff", "#00e7ff", "#ff6c00", "#f7ff00", "#914122", "#6b6b6b ", "#ffffff");
$random_colors = $colors[array_rand($colors)];


if(!isset($_SESSION['connected']))  {
  if(!empty($_POST['username']) && isset($_POST['btn']))  {
    $chars = '/^[a-zA-Z0-9]+$/';
    $user_color = $random_colors;
    $username = htmlspecialchars($_POST['username']);

        // generate a unique token for each users
    do {
      $user_token = sha1(bin2hex(random_bytes(16)));
      $stmt = $base->prepare("SELECT COUNT(*) FROM users WHERE Token = :token");
      $stmt->execute(array(':token' => $user_token));
      $count = $stmt->fetchColumn();
    } while ($count > 0);

    if (!preg_match($chars, $username)) {
       // js error
    } elseif (strlen($username) > 15) {
       // js error
    } else {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['color'] = $user_color;
      
      $token = array(
          'username' => $username,
          'usercolor' => $user_color,
          'token' => $user_token,
      );
      $token_data = json_encode($token);

      $stmt = $base->prepare("INSERT INTO users (Username, Color, Token, Activity) VALUES (:username, :color, :token, NOW())");
      $stmt->execute(array(':username' => $username, ':color' => $user_color, ':token' => $user_token));
      setcookie('user_data', $token_data, time() + 60*60*24*365);

      header('Location: chat.php');
    }
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat app</title>
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta name="description" content="A simple chat app.">
    <link rel="stylesheet" href="style.css">
  </head>
  <body onload="Load()">
  <div id="load"></div>
  <div style="display:none;" id="show">
  <header id="header">
  </header>
  <div class="wrapper">
  <div class="box" id="box">
    </div>
  <form id="login" name="login" method="post">
    <input name="username" id="username" placeholder="Username" type="text" style="width: 100%; margin-bottom: 15px;" required autocomplete="off"></input>
    <input class="btn" name="btn" id="btn" type="submit" value="start chatting!" style="cursor: pointer; width: 103%"></input>
  </form>
	  </div>
  <footer>
  	<div class="link-column">
      <a href="https://github.com/Yuyuko1337/ajax-php-chat/" target="_blank">» Github</a>
	    <br>
	    <a href="https://yuyuko.ovh/" target="_blank">» yuyuko.ovh</a>
	    <br>
	    <br>
    </div>
  </footer>
  </div>
  </body>
  <script src="script.js"></script>
</html>

<?php }
?>
