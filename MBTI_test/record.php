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
    <script>
        function checkSurely() {
            var message = "작성한 검사 결과가 사라지고 다시 시작합니다.\n";
            message += "정말 다시 검사하시겠습니까?";
            return confirm(message);
        }
    </script>
</head>

<body>
    <h1><?= $idCookie ?>님의 MBTI 결과</h1>
    <h2>MBTI 타입: <?= $resTypeInfo['tname'] ?></h2>
    <h3>에너지 방향</h3>
    <p>외향(E) <?= $result['eisum'] ?> 내향(I)</p>
    <h3>인식 기능</h3>
    <p>감각(S) <?= $result['snsum'] ?> 직관(N)</p>
    <h3>판단 기능</h3>
    <p>사고(T) <?= $result['tfsum'] ?> 감정(F)</p>
    <h3>생활 양식</h3>
    <p>판단(J) <?= $result['jpsum'] ?> 인식(P)</p>
    <h2>유형에 따른 성격</h2>
    <p><?= $resTypeInfo['comment'] ?></p>
    <h2>유형에 관련된 직업</h2>
    <p><?= $resTypeInfo['related_job'] ?></p>

    <form action="process_retest.php" onsubmit="return checkSurely()">
        <input type="submit" value="MBTI 재검사하기">
    </form>
</body>

</html>