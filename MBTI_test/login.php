<?php
require_once('./lib/cookie.php');
if (checkLogin()) {
    if ($_GET['wid'] == 1)  header("Location: testing.php?level=0");
    else if ($_GET['wid'] == 2) header("Location: record.php");
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
    <form class="basicbox" action="process_login.php" method="POST">
        <h1>MBTI_test Login</h1>
        <input type="hidden" name="wid" value="<?= $_GET['wid'] ?>">
        <input type="text" name="uid" placeholder="ID">
        <input type="password" name="upasswd" placeholder="Password">
        <input type="submit" value="Login">
    </form>
</body>

</html>