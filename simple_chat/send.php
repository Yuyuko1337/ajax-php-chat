<?php
session_start();
include('admin/db.php');

if (isset($_SESSION['connected'])) {
  if (!empty($_POST['messages'])) {
    $messages = htmlspecialchars($_POST['messages']);
    $username = $_SESSION['connected'];
    $authorcl = $_SESSION['color'];
    $date = date('m-d-y');
    $hours = date('H:i');
    $id = $_SESSION['Id'];

    // limit retard spamming
    $max_msg_per_secs = 5;
    $msg_per_secs = isset($_SESSION['msg_per_secs']) ? $_SESSION['msg_per_secs'] : 0;
    $lastpost_time = isset($_SESSION['lastpost_time']) ? $_SESSION['lastpost_time'] : time();
    $time = time() - $lastpost_time;

    if ($time < 10 && $msg_per_secs >= $max_msg_per_secs) {
        // js error
    } else {
      if (strlen($messages) > 1500) {
        // js error
      } else {
        $stmt = $base->prepare("INSERT INTO messages (Postday, Content, Author, Authorcl, hours) VALUES (:postday, :content, :author, :authorcl, :hours)");
        $stmt->execute(array(':postday' => $date, ':content' => $messages, ':author' => $username, ':hours' => $hours, ':authorcl' => $authorcl));
        
        $stmt2 = $base->prepare("UPDATE users SET Activity = NOW() WHERE Id = :id");
        $stmt2->execute(array(':id' => $id));

        $_SESSION['msg_per_secs'] = $time < 10 ? $msg_per_secs + 1 : 1;
        $_SESSION['lastpost_time'] = time();
      }
    }
  }
}
?>
