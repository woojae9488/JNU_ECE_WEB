<html>

<?php

// DB -> getCWDInfoToParam으로 대체 완료
function getPageId(&$_pid, &$_id)
{
    if (!isset($_GET['page'])) return false;
    $_id = $_GET['page'];
    $_pid = substr($_id, 0, 4);
    $_id = substr($_id, 4, 2);
    settype($_pid, 'integer');
    settype($_id, 'integer');
    return true;
}

function sep_ClsNProf($cName, &$class, &$prof)
{
    $cName = explode('(', $cName);
    $class = $cName[0];
    $prof = substr($cName[1], 0, -1);
}
?>

</html> 