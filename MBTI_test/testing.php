<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbuser = new mbtiUser($dbconn);
$dbquest = new mbtiQuestion($dbconn);
$dbsel = new mbtiSelect($dbconn);

$tArr = $dbsel->types;
$level = $_GET['level'];
settype($level, 'integer');
$tArr = array_slice($tArr, $level * 2, 2);
$choices = array();
$tQuest1 = array();
$tQuest2 = array();

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

if ($_POST) {
    $preTArr = array_slice($tArr, ($level - 1) * 2, 2);
    // 이전 테스트에서 post로 받은 값을 디비에 저장
    // 테스트 기록 있는지 확인 후 
    // 없으면 insert 있으면 update 해야 한다.
    // 어떻게 폼으로 테스트 결과 보낼지부터 결정
}

if ($dbsel->checkSelectClear($idCookie)) {
    header("Location: record.php");
} else if (!$dbsel->checkSelectTypesEmpty($idCookie, $tArr)) {
    $choices = $dbsel->getSelectAll($idCookie, $tArr[0]);
}

$tQuest1 = $dbquest->getContentAll($tArr[0]);
$tQuest2 = $dbquest->getContentAll($tArr[1]);
if ($tQuest1 == null || $tQuest2 == null) {
    // 예외처리 하거나 아닐거면 if문 제거
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
    <script src="./lib/function.js"></script>
</head>

<body>
    <h1>MBTI_test</h1>
    <form name="qform" action="testing.php?level=<?= ($level + 1) ?>" method="POST">
        <?php
        for ($i = 0; $i < count($tQuest1); $i++) {
            echo $tQuest1[$i];
            echo '<input type="radio" class="qst1" name="q' . $i . '">';
            echo $tQuest2[$i];
            echo '<input type="radio" class="qst2" name="q' . $i . '">';
            echo '<br>';
        } // 테이블 형식으로 변경
        ?> 
        <input type="submit" value="다음" onclick="checkAllSelected()?:return false;">
    </form>
</body>

</html>