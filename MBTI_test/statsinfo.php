<?php
require_once('./lib/mbtiDB.php');

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
            echo "<h3>{$typeInfo['tname']} :</h3>\n";
            echo "<p>{$typeInfo['tcount']}</p>\n";
        }
        ?>
        <input type="button" value="홈으로 이동" onclick="location.href = 'index.php'">
    </div>
</body>

</html>