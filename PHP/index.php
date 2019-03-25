<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
// require_once('../lib/crub.php');
$db_ins = new DB();
$file_ins = new File();

$list = $db_ins->getClassList();
$file_ins->checkClassDir($list);

$db_ins->checkBasicPath();
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
    <h1>CRUD 파일 올리기 부분 수정</h1>
    <h1>파일일 경우 링크 따로 걸어주기</h1>
    <h2><?= $cwdName ?></h2>
    <ul>
        <?php
        echo '<li><a href="index.php">Home</a></li>';
        for ($i = 0; $i < count($subList); $i++) {
            $id = sprintf('%04d%02d', $cwdId, $i + 1);
            echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
        }
        ?>
    </ul>
    <?php
    if ($cwdPid > 0) {
        ?>
    <form action="process_upload.php?page=<?= $_GET['page'] ?>" method="post" enctype="multipart/form-data">
        <p>Select File to Upload :</p>
        <input type="hidden" name="page" value="<?= $_GET['page'] ?>">
        <input type="file" name="upfile" id="upfile">
        <input type="submit" value="Upload file">
        <?php 
    } ?>
</body>

</html> 