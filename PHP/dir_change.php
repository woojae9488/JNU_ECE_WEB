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
    <h2><?= $cwdName ?></h2>
    <ul>
        <?php
        echo '<li><a href="index.php">Home</a></li>';
        for ($i = 0; $i < count($subList); $i++) {
            $id = sprintf('%04d%02d', $cwdId, $i + 1);
            echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
    <table>
        <td>
            <form action="dir_create.php" method="post">
                <input type="hidden" name="pid" value="<?= $cwdPid ?>">
                <input type="hidden" name="id" value="<?= $cwdPid ?>">
                <input type="submit" value="Create">
            </form>
        </td>
        <td>
            <form action="dir_change.php" method="post">
                <input type="hidden" name="pid" value="<?= $cwdPid ?>">
                <input type="hidden" name="id" value="<?= $cwdPid ?>">
                <input type="submit" value="Update or Delete">
            </form>
        </td>
    </table>
</body>

</html> 