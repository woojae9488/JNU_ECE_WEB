<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
$db_ins = new DB();
$file_ins = new File();
?>

<!DOCTYPE HTML>
<html lang="ko">

<head>
    <title>KWJ_WEB first</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>WEB Test Header1</h1>
    <?php
    $list = $db_ins->getClassList();
    $file_ins->dirCreate($list);
    ?>
</body>

</html> 