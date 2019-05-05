<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbsel = new mbtiSelect($dbconn);
$dbresult = new mbtiResult($dbconn);
$dbtype = new mbtiType($dbconn);

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

if (array_key_exists('test', $_GET)) {
    if (!$dbresult->getResultInfo($idCookie)) {
        $dbresult->calcAndPushResult($idCookie);
    } else {
        $dbresult->calcAndPushResult($idCookie, true);
    }
}

$result = null;
if (!($result = $dbresult->getResultInfo($idCookie))) {
    $message = "MBTI 테스트 기록이 아직 없습니다.";
    echo "<script>\n";
    echo "alert('{$message}');\n";
    echo "location.href = 'testing.php?level=0';\n";
    echo "</script>\n";
}
$resTypeInfo = $dbtype->getTypeInfoById($result['tid']);
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
    <div class="textbox">
        <h1><?= $idCookie ?>님의 MBTI 결과</h1>
        <div id="individual-resultbox" class="resultbox">
            <h2>MBTI 타입: <?= $resTypeInfo['tname'] ?></h2>
            <h3>에너지 방향</h3>
            <span>외향(E)</span>
            <canvas id="canvas1" width=360 height=40></canvas>
            <span>내향(I)</span>
            <h3>인식 기능</h3>
            <span>감각(S)</span>
            <canvas id="canvas2" width=360 height=40></canvas>
            <span>직관(N)</span>
            <h3>판단 기능</h3>
            <span>사고(T)</span>
            <canvas id="canvas3" width=360 height=40></canvas>
            <span>감정(F)</span>
            <h3>생활 양식</h3>
            <span>판단(J)</span>
            <canvas id="canvas4" width=360 height=40></canvas>
            <span>인식(P)</span>
        </div>
        <div class="resultbox">
            <h2>유형에 따른 성격</h2>
            <p><?= $resTypeInfo['comment'] ?></p>
        </div>
        <div class="resultbox">
            <h2>유형에 관련된 직업</h2>
            <p><?= $resTypeInfo['related_job'] ?></p>
        </div>

        <input type="button" value="MBTI 재검사하기" onclick="return checkSurely()">
        <input type="button" value="홈으로 이동" onclick="location.href = 'index.php'">
    </div>
    <a id="login" href="process_logout.php">Logout</a>
    <script>
        drawScoreCircle("canvas1", <?= $result['eisum'] ?>);
        drawScoreCircle("canvas2", <?= $result['snsum'] ?>);
        drawScoreCircle("canvas3", <?= $result['tfsum'] ?>);
        drawScoreCircle("canvas4", <?= $result['jpsum'] ?>);
    </script>
</body>

</html>