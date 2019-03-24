<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
$db_ins = new DB();
$file_ins = new File();

$list = $db_ins->getClassList();
$file_ins->checkClassDir($list);
$db_ins->checkBasicPath();
$subList = $file_ins->getSubList();
$db_ins->checkPageList($subList);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ_WEB Index</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>KWJ Class List</h1>
    <ul>
        <?php
        for ($i = 0; $i < count($list); $i++) {
            echo '<li><a href="' . $file_ins->get_bPath() . $list[$i] . '">' . $list[$i] . '</a></li>';
        }
        ?>
    </ul>
</body>

</html> 