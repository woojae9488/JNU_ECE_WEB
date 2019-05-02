<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbquest = new mbtiQuestion($dbconn);
$dbsel = new mbtiSelect($dbconn);

$tArr = $dbsel->types;
$level = $_GET['level'];
$curTArr = array_slice($tArr, $level * 2, 2);
$choices = array();
$records = null;
$tQuest1 = null;
$tQuest2 = null;

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

if ($_POST) {
    $preTArr = array_slice($tArr, ($level - 1) * 2, 2);
    for ($i = 0; $i < count($_POST); $i++) {
        array_push($choices, $_POST["q{$i}"]);
    }
    $dbsel->deleteSelectAll($idCookie, $preTArr[0]);
    $dbsel->pushSelectAll($idCookie, $preTArr[0], $choices);
    for ($i = 0; $i < count($_POST); $i++) {
        $choices[$i] ^= 1;
    }
    $dbsel->deleteSelectAll($idCookie, $preTArr[1]);
    $dbsel->pushSelectAll($idCookie, $preTArr[1], $choices);
}

if ($dbsel->checkSelectClear($idCookie)) {
    header("Location: record.php?test=1");
} else if (!$dbsel->checkSelectTypesEmpty($idCookie, $curTArr)) {
    $records = $dbsel->getSelectAll($idCookie, $curTArr[0]);
}

$tQuest1 = $dbquest->getContentAll($curTArr[0]);
$tQuest2 = $dbquest->getContentAll($curTArr[1]);
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
    <script>
        function checkAllSelected() {
            var question1 = document.querySelectorAll('.qst1');
            var question2 = document.querySelectorAll('.qst2');
            for (var i = 0; i < question1.length; i++) {
                if (!question1[i].checked && !question2[i].checked) {
                    alert(`${i + 1}번째 문제를 아직 선택하지 않았습니다!!`);
                    return false;
                }
            }
            return true;
        }
    </script>
</head>

<body>
    <h1>MBTI_test</h1>
    <form action="testing.php?level=<?= ($level + 1) ?>" method="POST">
        <?php
        for ($i = 0; $i < count($tQuest1); $i++) {
            echo $tQuest1[$i] . "\n";
            echo "<input type='radio' class='qst1' name='q{$i}' value='1'";
            if ($records && $records[$i] == 1) echo " checked='checked'";
            echo ">\n" . $tQuest2[$i] . "\n";
            echo "<input type='radio' class='qst2' name='q{$i}' value='0'";
            if ($records && $records[$i] == 0) echo " checked='checked'";
            echo "><br>\n";
        }
        // 테이블 형식으로 변경 태그도 생각
        ?>
        <input type="button" value="이전" onclick="history.back()">
        <input type="submit" value="다음" onclick="return checkAllSelected()">
    </form>
</body>

</html>