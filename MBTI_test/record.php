<?php
// 검사 다시하기 기능 있어야 함
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbsel = new mbtiSelect($dbconn);
$dbresult = new mbtiResult($dbconn);

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

if ($_GET['test']) {
    if (!$dbresult->getResultInfo($idCookie))
        $dbresult->calcAndPushResult($idCookie);
    else
        $dbresult->calcAndPushResult($idCookie, true);
}

$result = null;
if (!($result = $dbresult->getResultInfo($idCookie))) {
    $message = "MBTI 테스트 기록이 아직 없습니다.";
    echo "<script>\n";
    echo "alert('{$message}');\n";
    echo "location.href = 'testing.php?level=0';\n";
    echo "</script>\n";
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
</head>

<body>
    <h1>MBTI_test</h1>
    <h2><?= $idCookie ?>님의 MBTI 결과</h2>
    <!-- mbti 타입 출력 -->
    <!-- mbti 타입별 점수 출력 -->
</body>

</html>