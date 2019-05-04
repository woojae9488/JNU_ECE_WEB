<?php
require_once('./lib/mbtiDB.php');
require_once('./lib/cookie.php');

$mbti = new mbtiDB();
$dbconn = $mbti->getMBTIDB();
$dbsel = new mbtiSelect($dbconn);

if (!checkLogin()) header("Location: index.php");
$idCookie = $_COOKIE['id'];

$dbsel->deleteSelectTotal($idCookie);
header("Location: testing.php?level=0");
?>