<html>

<?php
class DB
{
    private $conn;
    public $result;

    function __construct($id = 'woojaek', $passwd = '12345678')
    {
        $this->conn = mysqli_connect(
            '127.0.0.1',
            $id,
            $passwd,
            'my_webf',
            '3307'
        );
    }

    function getCWDInfo($case = 2)
    {
        if (!isset($_GET['page'])) {
            return "KWJ Class List";
        } else {
            $id = $_GET['page'];
            $parent_id = substr($id, 0, 4);
            $id = substr($id, 4, 2);
            settype($id, 'integer');
            settype($parent_id, 'integer');
            $sql = "SELECT * FROM local_page WHERE
             parent_id={$parent_id} AND page_id={$id}";
            $result = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_array($result);
            switch ($case) {
                case 0:
                    return $id;
                case 1:
                    return $row['path'];
                case 2:
                    return substr($row['path'], 8);
            }
        }
    }

    function getClassList()
    {
        if (isset($_GET['page'])) return;
        $classList = array();
        $sql =
            "SELECT class.name, professor.name FROM class 
        LEFT JOIN professor ON class.professor_id=professor.id";
        $this->result = mysqli_query($this->conn, $sql);
        while ($row = mysqli_fetch_array($this->result)) {
            array_push($classList, $row[0] . '(' . $row[1] . ')');
        }

        return $classList;
    }

    function checkBasicPath($bPath = null)
    {
        if (isset($_GET['page'])) return;
        if (!isset($bPath)) $bPath = "../Data";
        $children_cnt = count(scandir($bPath)) - 2;

        $sql =
            "SELECT * FROM local_page WHERE page_id=0 AND parent_id=0";
        $result = mysqli_query($this->conn, $sql);
        $row = mysqli_fetch_array($result);
        if (!isset($row)) {
            $sql =
                "INSERT INTO local_page VALUES(-1,0,'{$bPath}',{$children_cnt})";
            mysqli_query($this->conn, $sql);
        } else {
            $cnt = $row['children_cnt'];
            settype($cnt, 'integer');
            if ($cnt != $children_cnt) {
                $sql =
                    "UPDATE local_page SET children_cnt={$children_cnt})
                    WHERE page_id=0 AND parent_id=0";
                mysqli_query($this->conn, $sql);
            }
        }
    }

    function getSubList($bPath = null)
    {
        if (!isset($_GET['page'])) {
            $bPath = '../Data/';
        } else {
            $id = $_GET['page'];
            $parent_id = substr($id, 0, 4);
            $id = substr($id, 4, 2);
            settype($parent_id, 'integer');
            settype($id, 'integer');
            $bPath = $this->getPPath($parent_id, $id) . '/';
        }

        $subList = array_diff(scandir($bPath), array('.', '..'));
        array_multisort($subList);
        return $subList;
    }

    // $list = File -> getSubList
    function checkPageList($subList, $bPath = null)
    {
        if (!isset($bPath)) $bPath = "../Data/";
        $id = 0;
        $parent_id = 0;
        if (isset($_GET['page'])) {
            $id = $_GET['page'];
            $parent_id = substr($id, 0, 4);
            $id = substr($id, 4, 2);
            settype($parent_id, 'integer');
            settype($id, 'integer');
            $bPath = $this->getPPath($parent_id, $id) . '/';
        }

        $sql = "SELECT * FROM local_page WHERE parent_id={$id}";
        $result = mysqli_query($this->conn, $sql);

        for ($i = 0; $i < count($subList); $i++) {
            $row = null;
            $fPath = $bPath . $subList[$i];
            $child_cnt = count(scandir($fPath)) - 2;
            $nid = $i + 1;
            if (!($row = mysqli_fetch_array($result))) {
                $this->mkPList($id, $nid, $fPath, $child_cnt);
                continue;
            };

            $cid = $row['page_id'];
            settype($cid, 'integer');
            $cnt = $row['children_cnt'];
            settype($cnt, 'integer');
            $res = ($cid != $nid) || ($row['path'] != $fPath) || ($cnt != $child_cnt);
            if ($res) {
                $this->chPList($id, $cid, $nid, $fPath, $child_cnt);
            }
        }
        while ($row = mysqli_fetch_array($result)) {
            $cid = $row['page_id'];
            settype($cid, 'integer');
            $this->rmPList($id, $cid);
        }
    }

    private function mkPList($pid, $id, $path, $cnt)
    {
        $sql = "INSERT INTO local_page VALUES
         ({$pid},{$id},'{$path}',{$cnt})";
        if (!mysqli_query($this->conn, $sql)) {
            echo "make error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
    }

    private function chPList($pid, $id, $cid, $path, $cnt)
    {
        $sql = "UPDATE local_page SET page_id={$cid},
         path='{$path}',children_cnt={$cnt} WHERE
         parent_id={$pid} AND page_id={$id}";
        if (!mysqli_query($this->conn, $sql)) {
            echo "change error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
    }

    private function rmPList($pid, $id)
    {
        $sql = "DELETE FROM local_page WHERE 
         parent_id={$pid} AND page_id={$id}";
        if (!mysqli_query($this->conn, $sql)) {
            echo "remove error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
    }

    private function getPPath($pid, $id)
    {
        $sql = "SELECT path FROM local_page WHERE 
         parent_id={$pid} AND page_id={$id}";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
        $row = mysqli_fetch_array($result);
        return $row['path'];
    }
}
?>

</html> 