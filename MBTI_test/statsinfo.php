<?php
require_once('./lib/cookie.php');
require_once('./lib/mbtiDB.php');

$loginBtn = "Login";
$loginLink = "login.php?wid=00";
if (checkLogin()) {
    $loginBtn = "Logout";
    $loginLink = "process_logout.php";
}

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbtype = new mbtiType($dbconn);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
    <link rel="stylesheet" href="./lib/style.css">
</head>

<body>
    <div class="statsbox">
        <h1>MBTI Type Stats</h1>
        <?php
        for ($i = 0; $i < $dbtype->getTypeCnt(); $i++) {
            $typeInfo = $dbtype->getTypeInfoById($i + 1);
            echo "<div id='{$typeInfo['tname']}'>";
            echo "<h3>{$typeInfo['tname']}</h3>\n";
            echo "<span>{$typeInfo['tcount']}</span>\n";
            echo "</div>";
        }
        ?>
        <input type="button" value="홈으로 이동" onclick="location.href = 'index.php'">
    </div>
    <a id="login" href=<?= $loginLink ?>><?= $loginBtn ?></a>
</body>

</html>