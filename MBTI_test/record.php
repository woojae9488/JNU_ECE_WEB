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
    <script>
        function checkSurely() {
            var message = "작성한 검사 결과가 사라지고 다시 시작합니다.\n";
            message += "정말 다시 검사하시겠습니까?";
            if (confirm(message)) {
                location.href = "process_retest.php";
            }
        }
    </script>
</head>

<body>
    <div class="textbox">
        <h1><?= $idCookie ?>님의 MBTI 결과</h1>
        <div class="resultbox">
            <h2>MBTI 타입: <?= $resTypeInfo['tname'] ?></h2>
            <h3>에너지 방향</h3>
            <p>외향(E) <?= $result['eisum'] ?> 내향(I)</p>
            <h3>인식 기능</h3>
            <p>감각(S) <?= $result['snsum'] ?> 직관(N)</p>
            <h3>판단 기능</h3>
            <p>사고(T) <?= $result['tfsum'] ?> 감정(F)</p>
            <h3>생활 양식</h3>
            <p>판단(J) <?= $result['jpsum'] ?> 인식(P)</p>
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
</body>

</html>