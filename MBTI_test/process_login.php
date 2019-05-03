<? ?>
<?php 
require_once('./lib/mbtiDB.php');
$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbuser = new mbtiUser($dbconn);

$wid = $_POST['wid'];
$uid = $_POST['uid'];
$upw = $_POST['upasswd'];

if ($wid == 1) {
    if ($dbuser->enrollUser($uid, $upw)) {
        setcookie('id', $uid);
        header("Location: testing.php?level=0");
    } else if ($dbuser->getUserInfo($uid, $upw)) {
        setcookie('id', $uid);
        header("Location: testing.php?level=0");
    } else {
        $message = "잘못된 로그인입니다.";
        echo "<script>\n";
        echo "alert('{$message}');\n";
        echo "location.href = 'login.php?wid={$wid}';\n";
        echo "</script>\n";
        //header("Location: login.php?wid={$wid}");
    }
} else if ($wid == 2) {
    if ($dbuser->getUserInfo($uid, $upw)) {
        setcookie('id', $uid);
        header("Location: record.php");
    } else {
        $message = "존재하는 ID가 없거나 잘못된 로그인입니다.";
        echo "<script>\n";
        echo "alert('{$message}');\n";
        echo "location.href = 'login.php?wid={$wid}';\n";
        echo "</script>\n";
        //header("Location: login.php?wid={$wid}");
    }
}
?>