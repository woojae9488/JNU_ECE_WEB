<?php
require_once('../lib/database.php');
require_once('../lib/filesystem.php');
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

$page = "";
if (isset($_GET['page'])) {
    $page .= "?page={$_GET['page']}";
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>KWJ WEB First</title>
    <meta charset="UTF-8">
</head>

<body>
    <!--<h1>폴더 추가 삭제 수정 가능하게</h1>-->
    <!--<h1>폴더 추가시 하위 폴더 상태(파일과 비슷하게 생각)</h1>-->
    <!--<h1>file 관련 기본 함수들 확인</h1>-->
    <h2><?= $cwdName ?></h2>

    <?php
    if ($cwdPid > 0) {
        ?>
    <p><a href="index.php">Home</a></p>
    <table border="1">
        <thead>
            <td>File Name</td>
            <td>Download</td>
            <td>Delete</td>
        </thead>
        <tbody>
            <?php
            for ($i = 0; $i < count($subList); $i++) {
                $id = $cwdPid * 100 + $cwdId;
                ?>
            <tr>
                <td><?= $subList[$i] ?></td>
                <td>
                    <form action="process_download.php" method="post">
                        <input type="hidden" name="page" value="<?= $id ?>">
                        <input type="hidden" name="file" value="<?= ($i + 1) ?>">
                        <input type="submit" value="Download">
                    </form>
                </td>
                <td>
                    <form action="process_file_delete.php" method="post" onsubmit="if(!confirm('sure?'))return false;">
                        <input type="hidden" name="page" value="<?= $id ?>">
                        <input type="hidden" name="file" value="<?= ($i + 1) ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
            <?php 
        } ?>
        </tbody>
    </table>
    <form action="process_upload.php<?= $page ?>" method="post" enctype="multipart/form-data">
        <p>Select File to Upload :</p>
        <input type="hidden" name="page" value="<?= $_GET['page'] ?>">
        <input type="file" name="upfile" id="upfile">
        <input type="submit" value="Upload file">
        <?php 
    } else { ?>
        <ul>
            <?php
            echo '<li><a href="index.php">Home</a></li>';
            for ($i = 0; $i < count($subList); $i++) {
                $id = sprintf('%04d%02d', $cwdId, $i + 1);
                echo '<li><a href="index.php?page=' . $id . '">' . $subList[$i] . '</a></li>';
            }
            ?>
        </ul>
        <td>
            <form action="dir_create.php<?= $page ?>" method="post">
                <input type="hidden" name="pid" value="<?= $cwdPid ?>">
                <input type="hidden" name="id" value="<?= $cwdPid ?>">
                <input type="submit" value="Create">
            </form>
        </td>
        <?php 
    } ?>
</body>

</html> 