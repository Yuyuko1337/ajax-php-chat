<?php
include('admin/db.php');
include 'send.php';

if (isset($_COOKIE['user_data'])) {

    $user_data = json_decode($_COOKIE['user_data'], true);
    $username = $user_data['username'];
    $user_token = $user_data['token'];
    $user_cl = $user_data['usercolor'];

    if (isset($_SESSION['connected'])) {
        $stmt = $base->prepare("UPDATE users SET Activity=NOW() WHERE Token=?");
        $stmt->execute([$user_token]);
    }
}

$stmt = $base->prepare("SELECT COUNT(*) as count FROM users WHERE Activity > DATE_SUB(NOW(), INTERVAL 1 MINUTE)");
$stmt->execute();
$row = $stmt->fetch();
$online = $row['count'];

?>

<p style="text-align:right; color: #5f00b7;">» online: <span style="color: #c1bbff;  font-family: system-ui;"><?php echo htmlspecialchars($online); ?></span> </p>

