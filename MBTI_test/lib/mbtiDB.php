<?php
class mbtiDB
{
    private $conn;

    function __construct($id = 'woojaek', $passwd = '12345678')
    {
        $this->conn = mysqli_connect(
            'localhost',
            $id,
            $passwd,
            'mbti_test',
            '3307'
        );
    }

    function getMBTIDB()
    {
        return $this->conn;
    }
}

class mbtiQuestion
{
    private $conn;
    private $qcount;

    function __construct($conn)
    {
        $this->conn = $conn;
        $this->qcount = 9;
    }

    function getContent($qnum, $qtype)
    {
        $sql = "SELECT * FROM mbti_question 
        WHERE qnum={$qnum} AND qtype='{$qtype}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "question read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
        $row = mysqli_fetch_array($result);

        return $row['qcontent'];
    }
}

class mbtiType
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function getTypeInfoByName($tname)
    {
        $sql = "SELECT * FROM mbti_type 
                WHERE tname='{$tname}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "type read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
        $row = mysqli_fetch_array($result);

        return $row;
    }

    function getTypeInfoById($tid)
    {
        $sql = "SELECT * FROM mbti_type 
                WHERE tname='{$tid}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "type read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
        $row = mysqli_fetch_array($result);

        return $row;
    }

    function increaseTypeCnt($tname)
    {
        $row = $this->getTypeInfoByName($tname);
        $typeCnt = $row['tcount'];
        settype($typeCnt, 'integer');
        $typeCnt++;

        $sql = "UPDATE mbti_type SET tcount={$typeCnt} 
                WHERE tname={$tname}";
        if (!mysqli_query($this->conn, $sql)) {
            echo "tcount update error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
        }
    }
}
?>