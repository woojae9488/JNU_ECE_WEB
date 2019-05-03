<?php
function checkLogin()
{
    if (!$_COOKIE) return false;
    else if ($_COOKIE['id']) return true;
    else return false;
}
?>
            