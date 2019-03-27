<html>

<?php
require_once('../lib/database.php');
$db_ins = new DB();
$pid = $_POST['page'];
$id = $_POST['file'];
$path = $db_ins->getPPath($pid, $id);
$name = end(explode('/', $path)); //something is wlong...
$filesize = filesize($path);

if (file_exists($path)) {
    header("Content-Type:application/octet-stream");
    header("Content-Disposition:attachment;filename=$name");
    header("Content-Transfer-Encoding:binary");
    header("Content-Length:" . $filesize);
    header("Cache-Control:cache,must-revalidate");
    header("Pragma:no-cache");
    header("Expires:0");
    if (is_file($path)) {
        $fp = fopen($path, "r");
        while (!feof($fp)) {
            $buf = fread($fp, 8096);
            $read = strlen($buf);
            print($buf);
            flush();
        }
        fclose($fp);
    }
} else {
    echo "파일 다운로드 에러";
}
?>

</html> 