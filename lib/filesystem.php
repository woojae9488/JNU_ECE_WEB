<html>

<?php
class File
{
    private $bPath;

    function __construct($bPath = '../Data/')
    {
        $this->bPath = $bPath;
    }

    function dirCreate($checkList)
    {
        for ($i = 0; $i < count($checkList); $i++) {
            $fPath = $this->bPath . $checkList[$i];
            if (!file_exists($fPath)) {
                mkdir($fPath);
            }
        }
    }
}
?>

< /html> 