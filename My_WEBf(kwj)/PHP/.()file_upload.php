<?php
require_once('../lib/database.php');
require_once('../lib/crub.php');
$db_ins = new DB();

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
    <title>KWJ WEB Fisrt</title>
    <meta charset="UTF-8">
</head>

<body>
    <h2><?= '파일 올리기 (' . $cwdName . ')' ?></h2>
    <ul>
        <?php
        echo '<li><a href="index.php">Home</a></li>';
        for ($i = 0; $i < count($subList); $i++) {
            $id = sprintf('%04d%02d', $cwdId, $i + 1);
            echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
    
    </form>
</body>

</html> 