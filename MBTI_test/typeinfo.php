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
    <script src="./lib/function.js"></script>
</head>

<body>
    <div class="typebox">
        <h1>MBTI Type Information</h1>
        <?php
        for ($i = 0; $i < $dbtype->getTypeCnt(); $i++) {
            $typeInfo = $dbtype->getTypeInfoById($i + 1);
            echo "<h2>{$typeInfo['tname']}</h2>\n";
            echo "<div id='{$typeInfo['tname']}'>";
            echo "<h4>성격</h4>\n";
            echo "<p>{$typeInfo['comment']}</p>\n";
            echo "<h4>관련 직업</h4>\n";
            echo "<p>{$typeInfo['related_job']}</p>\n";
            echo "</div>";
        }
        ?>
        <input id="home" type="button" value="홈으로 이동" onclick="location.href = 'index.php'">
    </div>
    <a id="login" href=<?= $loginLink ?>><?= $loginBtn ?></a>
    <script>addTypesEvent()</script>
</body>

</html>