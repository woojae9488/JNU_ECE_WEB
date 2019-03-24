<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
$db_ins = new DB();
$file_ins = new File();

$list = $db_ins->getClassList();
$file_ins->checkClassDir($list);
$db_ins->checkBasicPath();
$subList = $db_ins->getSubList();
$db_ins->checkPageList($subList);

$cwdId = $db_ins->getCWDInfo(0);
$cwdPath = $db_ins->getCWDInfo(1);
$cwdName = $db_ins->getCWDInfo(2);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ WEB F</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>파일일 때 parent_id를 3글자로 해야한다.</h1>
    <h1><?= $cwdName ?></h1>
    <ul>
        <?php
        echo '<li><a href="index.php">Home</a></li>';
        for ($i = 0; $i < count($subList); $i++) {
            $id = sprintf('%04d%02d', $cwdId, $i + 1);
            echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
</body>

</html> 