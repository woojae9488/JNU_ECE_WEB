<? ?>
<?php
$tArr = ['E', 'I', 'S', 'N', 'T', 'F', 'J', 'P'];
$level = 1;
settype($level, 'integer');
$tArr = array_slice($tArr, $level * 2, 2);
var_dump($tArr);
?>