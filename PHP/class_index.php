<?php
require_once('../lib/filesystem.php');
$path = getcwd();
$localfile = new Localfile($path);
$path = substr($path, strrpos($path, '\\') + 1);
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ_WEB(<?= $path ?>)</title>
    <meta charset="UTF-8">
</head>

<body>
    <h1><?= $path ?></h1>
    <ul>
        <?php
        $subList = $localfile->getSubList();
        for ($i = 2; $i < count($subList) + 2; $i++) {
            $listPath = './' . $subList[$i];
            echo '<li><a href="' . $listPath . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
</body>

</html> 