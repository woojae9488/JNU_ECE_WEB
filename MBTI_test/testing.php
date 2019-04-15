<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbuser = new mbtiUser($dbconn);
$dbsel = new mbtiSelect($dbconn);
$choices = array();

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

if ($dbsel->checkSelectClear($idCookie)) {
    header("Location: record.php");
} else {
    $tArr = $dbsel->types;
    $level = $_GET['level'];
    settype($level, 'integer');
    $tArr = array_slice($tArr, $level * 2, 2);

    if (!$dbsel->checkSelectTypesEmpty($idCookie, $tArr)) {
        $array = $dbsel->getSelectAll($idCookie, $tArr[0]);
    }
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

</body>

</html>