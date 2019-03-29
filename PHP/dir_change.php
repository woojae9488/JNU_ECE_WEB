<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
require_once('../lib/crub.php');
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
    <h2><?= $cwdName ?>(Change)</h2>
    <!--<h1>테이블 형식으로 이름인풋, 업데이트, 델리트</h1>-->
    <p><a href="index.php">Home</a></p>
    <?php
    echo "<table><tbody>";
    for ($i = 0; $i < count($subList); $i++) {
        $a; $b;
        sep_ClsNProf($subList[$i],$a,$b);
        exit;
        $id = sprintf('%04d%02d', $cwdId, $i + 1);
        echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
    }
    echo "</tbody></table>";
    ?>
</body>

</html> 