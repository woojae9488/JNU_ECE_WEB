<? ?>
<?php
function checkLogin()
{
    if ($_COOKIE['id']) return true;
    else {
        return false;
    }
}
?>
            