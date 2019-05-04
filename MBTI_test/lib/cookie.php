<?php
function checkLogin()
{
    if (!$_COOKIE) return false;
    else if (array_key_exists('id', $_COOKIE)) return true;
    else return false;
}
?>