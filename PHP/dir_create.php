<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
$db_ins = new DB();
$file_ins = new File();

$subList = $db_ins->getSubList();
$db_ins->checkPageList($subList);

$cwdPid = 0;
$cwdId = 0;
$cwdPath = "";
$cwdName = "";
$db_ins->getCWDInfoToParam($cwdPid, $cwdId, $cwdPath, $cwdName);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ WEB First</title>
    <meta charset="UTF-8">
</head>

<body>
    <h2><?= $cwdName ?>(Create)</h2>
    <ul>
        <?php
        echo '<li><a href="index.php">Home</a></li>';
        for ($i = 0; $i < count($subList); $i++) {
            $id = sprintf('%04d%02d', $cwdId, $i + 1);
            echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
    <?php
    if ($cwdId == 0) {
        ?>
    <form action="process_create_dir.php" method="post">
        <p>Class name :
            <input type="text" name="className" placeholder="Class"></p>
        <p>Professor name :
            <input type="text" name="profName" placeholder="Professor"></p>
        <input type="hidden" name="pid" value=<?= $cwdPid ?>>
        <input type="hidden" name="id" value=<?= $cwdId ?>>
        <input type="submit" value="Create Directory">
    </form>
    <?php 
} else { ?>
    <form action="process_create_dir.php" method="post">
        Directory name :
        <input type="text" name="dirName">
        <input type="hidden" name="pid" value=<?= $cwdPid ?>>
        <input type="hidden" name="id" value=<?= $cwdId ?>>
        <input type="submit" value="Create Directory">
    </form>
    <?php 
} ?>
</body>

</html> 