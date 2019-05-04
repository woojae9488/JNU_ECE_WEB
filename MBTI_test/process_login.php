<?php
require_once('./lib/mbtiDB.php');
$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbuser = new mbtiUser($dbconn);

$wid = $_POST['wid'];
$uid = $_POST['uid'];
$upw = $_POST['upasswd'];

$location = "Location: index.php";
if ($wid == 1) $location = "Location: testing.php?level=0";
else if ($wid == 2) $location = "Location: record.php";
$message = "ID가 이미 있거나 잘못된 로그인입니다.";

if ($wid == 0 || $wid == 1) {
    if ($dbuser->enrollUser($uid, $upw)) {
        setcookie('id', $uid);
        header($location);
    } else if ($dbuser->getUserInfo($uid, $upw)) {
        setcookie('id', $uid);
        header($location);
    }
} else if ($wid == 2) {
    if ($dbuser->getUserInfo($uid, $upw)) {
        setcookie('id', $uid);
        header($location);
    } else {
        $message = "존재하는 ID가 없거나 잘못된 로그인입니다.";
    }
}
echo "<script>\n";
echo "alert('{$message}');\n";
echo "location.href = 'login.php?wid={$wid}';\n";
echo "</script>\n";
?>