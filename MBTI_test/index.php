<?php
require_once('./lib/mbtiDB.php');
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <title>MBTI TEST</title>
</head>

<body>
    <?php
    $type = ['E', 'I', 'S', 'N', 'T', 'F', 'J', 'P'];
    $typeRes = "";
    for ($i = 0; $i < count($type); $i++) {
        $typeRes .= $type[$i];
    }
    var_dump($typeRes);
    ?>
</body>

</html>