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
</head>

<body>
    <h1>MBTI_test login</h1>
    <form action="process_login.php" method="POST">
        <input type="hidden" name="wid" value="<?= $_GET['wid'] ?>">
        <p>
            ID
            <input type="text" name="uid" placeholder="ID">
        </p>
        <p>
            PASSWORD
            <input type="password" name="upasswd" placeholder="password">
        </p>
        <input type="submit" value="login">
    </form>
</body>

</html>