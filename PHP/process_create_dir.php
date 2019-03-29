<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();
$pid = $_POST['pid'];
$id = $_POST['id'];
$path = $db_ins->getPPath($pid, $id);

if ($id == 0) {
    $clsName = $_POST['className'];
    $prfName = $_POST['profName'];
    $prof_id = $db_ins->getProfessor($prfName);
    $db_ins->getClass($clsName, $prof_id);
} else {
    $dirName = $_POST['dirName'];
    $fPath = $path . '/' . $dirName;
    mkdir($fPath);
}

$page = sprintf("%04d%02d", $pid, $id);
header("Location: index.php?=" . $page);
?>

</html> 