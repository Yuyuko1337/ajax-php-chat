<?php
include('admin/db.php');
include 'send.php';
 
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
  } else {

    // no user found destroy cookie
    setcookie('user_data', '', time() - 3600);
    session_destroy();
    header('Location: index.php');
  }
}

if(isset($_SESSION['connected']))
	{
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
  <div id="error">
  </div>
  <form method="post" id="send" name="send" style="width: 65%;">
    <input class="messages" id="messages" name="messages" type="text" placeholder="type whatever you want" style="width: 100%; margin-bottom: 15px;" required autocomplete="off"></input>
    <input class="btn" name="btn" id="btn" type="submit" value="send" style="cursor: pointer; width: 20%; display: block;"></input>
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

<?php
}
else{
	header('Location: index.php');
}
?>
