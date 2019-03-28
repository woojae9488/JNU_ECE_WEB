<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();
$pid = $_POST['pid'];
$id = $_POST['id'];
$path = $db_ins->getPPath($pid, $id);
$dirName = $_POST['dirName'];

var_dump($path);
?>

</html> 