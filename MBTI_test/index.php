<?php
require_once('./lib/cookie.php');
$loginBtn = "Login";
$loginLink = "login.php?wid=00";
if (checkLogin()) {
    $loginBtn = "Logout";
    $loginLink = "process_logout.php";
}
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
    <link rel="stylesheet" href="./lib/style.css">
</head>

<body>
    <div class="centerbox">
        <h1>MBTI_test</h1>
        <a href="login.php?wid=01">MBTI 테스트 시작</a>
        <a href="login.php?wid=02">MBTI 기록 확인</a>
        <a href="typeinfo.php">MBTI 타입별 정보</a>
        <a href="statsinfo.php">MBTI 통계 보기</a>
    </div>
    <a id="login" href=<?= $loginLink ?>><?= $loginBtn ?></a>
</body>

</html>