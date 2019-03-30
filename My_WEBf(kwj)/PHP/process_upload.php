<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();

$cwdPid = 0;
$cwdId = 0;
$cwdPath = "";
$cwdName = "";
$db_ins->getCWDInfoToParam($cwdPid, $cwdId, $cwdPath, $cwdName);

$filePath = $cwdPath . basename($_FILES['upfile']['name']);
if (file_exists($filePath)) {
    unlink($filePath);
}
if ($_FILES['upfile']['size'] > 10000000) {
    echo 'File is too Big (Fix to under 10M)';
    echo '<p><a href="index.php?page=' . $_GET['page'] . '">돌아가기</a></p>';
} else if (move_uploaded_file($_FILES['upfile']['tmp_name'], $filePath)) {
    header("Location: index.php?page=" . $_GET['page']);
} else {
    echo '<p>Sorry, there was an error uploading your file.</p>';
    echo '<p><a href="index.php?page=' . $_GET['page'] . '">돌아가기</a></p>';
}
?>


</html> 