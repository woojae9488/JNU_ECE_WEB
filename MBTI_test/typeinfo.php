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
</head>

<body>
    <h1>MBTI Type Information</h1>
    <?php
    for ($i = 0; $i < $dbtype->getTypeCnt(); $i++) {
        $typeInfo = $dbtype->getTypeInfoById($i + 1);
        echo "<h2>{$typeInfo['tname']} =></h2>\n";
        echo "<h4>성격</h4>\n";
        echo "<p>{$typeInfo['comment']}</p>\n";
        echo "<h4>관련 직업</h4>\n";
        echo "<p>{$typeInfo['related_job']}</p><br>\n";
    }
    ?>
</body>

</html>