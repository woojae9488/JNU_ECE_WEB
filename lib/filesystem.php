<html>

<?php
class File
{
    private $bPath;

    function __construct($bPath = '../Data/')
    {
        $this->bPath = $bPath;
    }

    function get_bPath()
    {
        return $this->bPath;
    }

    function checkClassDir($checkList)
    {
        if (isset($_GET['page'])) return;
        for ($i = 0; $i < count($checkList); $i++) {
            $fPath = $this->bPath . $checkList[$i];
            if (!file_exists($fPath)) {
                mkdir($fPath);
            }
            $this->checkSubDir($fPath);
        }
    }

    private function checkSubDir($bPath, $subList = null)
    {
        if (isset($subList)) {
            for ($i = 0; $i < count($subList); $i++) {
                $fPath = $bPath . '/' . $subList[$i];
                if (!file_exists($fPath)) {
                    mkdir($fPath);
                }
            }
        } else {
            $subList = ['Lecture Document', 'Homework', 'etc'];
            $this->checkSubDir($bPath, $subList);
        }
    }

    // class_index ==> index distribution //
    // Not good at this Time..TT
    function checkSubList_Recur()
    {
        $subList = scandir($this->bPath);
        for ($i = 0; $i < count($subList); $i++) {
            if ($subList[$i] == '.' || $subList[$i] == '..') continue;

            $srcPath = './class_index.php';
            $desPath = $this->bPath . $subList[$i] . '/index.php';

            if (is_file($this->bPath . $subList[$i])) continue;

            else if (!file_exists($desPath)) {
                copy($srcPath, $desPath);
            } else if (filectime($srcPath) != filectime($desPath)) {
                copy($srcPath, $desPath);
            }
            $this->checkSubList_Recur($this->bPath . $subList[$i] . '/');
        }
    }
}
?>

</html> 