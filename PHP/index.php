<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
$db_ins = new DB();
$dbfile = new DBfile();
$localfile = new Localfile();
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ_WEB Index</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1>KWJ Class List</h1>
    <?php
    $list = $db_ins->getClassList();
    $dbfile->checkClassDir($list);
    $localfile->checkSubList_Recur();
    ?>
    <ul>
        <?php
        for ($i = 0; $i < count($list); $i++) {
            echo '<li><a href="' . $dbfile->get_bPath() . $list[$i] . '">' . $list[$i] . '</a></li>';
        }
        ?>
    </ul>
</body>

</html> 