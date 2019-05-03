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
    <h1>MBTI Type Stats</h1>
    <?php
    for ($i = 0; $i < $dbtype->getTypeCnt(); $i++) {
        $typeInfo = $dbtype->getTypeInfoById($i + 1);
        echo "<h3>{$typeInfo['tname']}</h3>\n";
        echo "<p>해당 타입의 회원 수: {$typeInfo['tcount']}</p>\n";
    }
    ?>
</body>

</html>