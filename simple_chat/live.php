<?php
include('admin/db.php');

// retrieve only 100 messages from db
$stmt = $base->prepare("SELECT * FROM messages ORDER BY id DESC LIMIT 100");
$stmt->execute();
$msgs = $stmt->fetchAll();

foreach ($msgs as $msg) {
    echo '<p class="msg"> <span style="color: #5f00b7">['.htmlspecialchars($msg["Postday"], ENT_QUOTES, 'UTF-8').']</span> <span class="time">'.htmlspecialchars($msg["Hours"], ENT_QUOTES, 'UTF-8').'</span> »
    <span style="color: '.htmlspecialchars($msg["Authorcl"], ENT_QUOTES, 'UTF-8').';">'.htmlspecialchars($msg["Author"], ENT_QUOTES, 'UTF-8').':</span> '.htmlspecialchars($msg["Content"], ENT_QUOTES, 'UTF-8').'
    </p>' ."\n";
  }
?>
