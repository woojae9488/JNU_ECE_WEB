<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();
$pid = $_POST['page'];
$id = $_POST['file'];

$path = $db_ins->getPPath($pid, $id);
$pid = sprintf("%06d", $pid);
if (unlink($path)) {
    header("Location: index.php?page=" . $pid);
} else {
    echo "파일 삭제 에러";
}
?>

</html> 