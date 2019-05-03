<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbquest = new mbtiQuestion($dbconn);
$dbsel = new mbtiSelect($dbconn);

$tArr = $dbsel->getTypeArr();
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
    header("Location: record.php?test=ok");
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
    <link rel="stylesheet" href="./lib/style.css">
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
    <div class="textbox">
        <h1>MBTI_test</h1>
        <form action="testing.php?level=<?= ($level + 1) ?>" method="POST">
            <div class="testquestion">
                <?php
                for ($i = 0; $i < count($tQuest1); $i++) {
                    echo "<span>" . ($i + 1) . ".</span>\n";
                    echo "<div>\n";
                    echo $tQuest1[$i] . "<br>\n";
                    echo $tQuest2[$i] . "\n</div>\n";
                    echo "<div name='radiobox'>\n";
                    echo "<input type='radio' class='qst1' name='q{$i}' value='1'";
                    if ($records && $records[$i] == 1) echo " checked='checked'><br>\n";
                    else echo "><br>\n";
                    echo "<input type='radio' class='qst2' name='q{$i}' value='0'";
                    if ($records && $records[$i] == 0) echo " checked='checked'>\n";
                    else echo ">\n";
                    echo "</div>\n";
                }
                ?>
            </div>
            <input type="button" value="이전" onclick="history.back()">
            <input type="submit" value="다음" onclick="return checkAllSelected()">
        </form>
    </div>
</body>

</html>