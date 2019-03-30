<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();
$pid = $_POST['page'];
$id = $_POST['file'];
$path = $db_ins->getPPath($pid, $id);
$path_parts = pathinfo($path);
$name = $path_parts['basename'];
$filesize = filesize($path);

if (file_exists($path)) {
    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$name");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: $filesize");

    ob_clean();
    flush();
    readfile($path);
} else {
    echo "파일 다운로드 에러";
}
?>

</html> 