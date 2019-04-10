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
            return null;
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
            return null;
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
            return null;
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
            return false;
        }
        return true;
    }

    function decreaseTypeCnt($tname)
    {
        $row = $this->getTypeInfoByName($tname);
        $typeCnt = $row['tcount'];
        settype($typeCnt, 'integer');
        $typeCnt--;

        $sql = "UPDATE mbti_type SET tcount={$typeCnt} 
                WHERE tname={$tname}";
        if (!mysqli_query($this->conn, $sql)) {
            echo "tcount update error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }
}

class mbtiUser
{
    private $conn;

    function __construct($conn)
    {
        $this->conn = $conn;
    }

    function enrollUser($id, $passwd)
    {
        $hashedPW = hash('sha256', $passwd);
        $sql = "INSERT INTO mbti_user 
                VALUES (${id}, '{$hashedPW}', NOW())";
        if (!mysqli_query($this->conn, $sql)) {
            echo "user enroll error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function getUserInfo($id, $passwd)
    {
        $hashedPW = hash('sha256', $passwd);
        $sql = "SELECT * FROM mbti_user
                WHERE uid='{$id}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "user read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return null;
        }
        $row = mysqli_fetch_array($result);

        if ($hashedPW != $row['upasswd']) return null;
        else return $row['created'];
    }

    function changePasswd($id, $oldpw, $newpw)
    {
        if ($this->getUserInfo($id, $oldpw)) {
            echo "기존 비밀번호 불일치!<br>";
            return false;
        }

        $hashedNPW = hash('sha256', $newpw);
        $sql = "UPDATE mbti_user SET upasswd='{$hashedNPW}'
                WHERE uid='{$id}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "password change error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function retireUser($id, $passwd)
    {
        if ($this->getUserInfo($id, $passwd)) {
            echo "기존 비밀번호 불일치!<br>";
            return false;
        }

        $sql = "DELETE FROM mbti_user WHERE uid='{$id}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "user retire error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }
}

class mbtiSelect
{
    private $conn;
    private $qcount;

    function __construct($conn)
    {
        $this->conn = $conn;
        $this->qcount = 9;
    }

    function getSelect($uid, $qtype, $qnum)
    {
        $sql = "SELECT * FROM mbti_sel WHERE uid='{$uid}'
                AND qnum={$qnum} AND qtype='{$qtype}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "select read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return null;
        }
        $row = mysqli_fetch_array($result);

        return $row['choice'];
    }

    function getSelectAll($uid, $qtype)
    {
        $sql = "SELECT * FROM mbti_sel 
                WHERE uid='{$uid}' AND qtype='{$qtype}'
                ORDER BY qnum";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "select read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return null;
        }
        $choiceArr = array();
        while ($row = mysqli_fetch($result)) {
            array_push($choiceArr, $row['choice']);
        }
        return $choiceArr; // 정확히 배열순서로 들어가는지 확인 필요!
    }

    function getSelectSum($uid, $qtype)
    {
        $sql = "SELECT SUM(choice) FROM mbti_sel
                WHERE uid='{$uid}' AND qtype='{$qtype}'";
        $result = null;
        if (!($result = mysqli_query($this->conn, $sql))) {
            echo "select read error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return null;
        }
        $row = mysqli_fetch($result);

        $sum = $row['SUM(choice)'];
        settype($sum, 'integer');
        return $sum;
    }

    function pushSelect($uid, $qtype, $qnum, $choice)
    {
        $boolValue = $choice ? 1 : 0;
        $sql = "INSERT INTO mbti_sel 
                VALUES('{$uid}', {$qnum}, '${qtype}', {$boolValue},)";
        if (!mysqli_query($this->conn, $sql)) {
            echo "select push error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function pushSelectAll($uid, $qtype, $choiceArr)
    {
        if (count($choiceArr) != $this->qcount) return false;
        for ($i = 0; $i < $this->qcount; $i++) {
            if ($this->pushSelect($uid, $qtype, $i + 1, $choiceArr[$i]))
                return false;
        }
        return true;
    }

    function changeSelect($uid, $qtype, $qnum, $choice)
    {
        $boolValue = $choice ? 1 : 0;
        $sql = "UPDATE mbti_sel 
                SET choice={$boolValue} WHERE uid='{$uid}' 
                AND qnum={$qnum} AND qtype='{$qtype}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "select change error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function changeSelectAll($uid, $qtype, $choiceArr)
    {
        if (count($choiceArr) != $this->qcount) return false;
        for ($i = 0; $i < $this->qcount; $i++) {
            if ($this->changeSelect($uid, $qtype, $i + 1, $choiceArr[$i]))
                return false;
        }
        return true;
    }

    function deleteSelect($uid, $qtype, $qnum)
    {
        $sql = "DELETE FROM mbti_sel WHERE uid='{$uid}'
                AND qnum={$qnum} AND qtype='{$qtype}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "select delete error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function deleteSelectAll($uid, $qtype)
    {
        $sql = "DELETE FROM mbti_sel WHERE uid='{$uid}'
                AND qtype='{$qtype}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "select delete error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }
}

class mbtiResult
{
    private $conn;
    private $testSel;
    private $testType;

    function __construct($conn)
    {
        $this->conn = $conn;
        $this->testSel = new mbtiSelect($conn);
        $this->testType = new mbtiType($conn);
    }

    private function pushResult($uid, $tid, $EISum, $SNSum, $TFSum, $JPSum)
    {
        $sql = "INSERT INTO mbti_res VALUES
        ('{$uid}',{$tid},{$EISum},{$SNSum},{$TFSum},{$JPSum})";
        if (!mysqli_query($this->conn, $sql)) {
            echo "result input error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    private function changeResult($uid, $newtid, $EISum, $SNSum, $TFSum, $JPSum)
    {
        $sql = "UPDATE mbti_res SET tid={$newtid}, eisum={$EISum},
                snsum={$SNSum}, tfsum={$TFSum}, jpsum={$JPSum}
                WHERE uid='{$uid}'";
        if (!mysqli_query($this->conn, $sql)) {
            echo "result input error 발생 log 파일 확인!<br>";
            error_log(mysqli_error($this->conn));
            return false;
        }
        return true;
    }

    function calcAndPushResult($uid, $changeFlag = false)
    {
        $tArr = ['E', 'I', 'S', 'N', 'T', 'F', 'J', 'P'];
        $tRes = array();
        for ($i = 0; $i < count($tArr); $i++) {
            $tRes[$i] = $this->testSel->getSelectSum($uid, $tArr[$i]);
        }

        $EISum = $tRes[0] - $tRes[1];
        $SNSum = $tRes[2] - $tRes[3];
        $TFSum = $tRes[4] - $tRes[5];
        $JPSum = $tRes[6] - $tRes[7];

        $tname = "";
        if ($EISum > 0) $tname .= "E";
        else $tname .= "I";
        if ($SNSum > 0) $tname .= "S";
        else $tname .= "N";
        if ($TFSum > 0) $tname .= "T";
        else $tname .= "F";
        if ($JPSum > 0) $tname .= "J";
        else $tname .= "P";

        $typeRow = $this->testType->getTypeInfoByName($tname);
        $tid = $typeRow['tid'];

        if ($changeFlag == false) {
            $this->testType->increaseTypeCnt($tname);
            $this->pushResult($uid, $tid, $EISum, $SNSum, $TFSum, $JPSum);
        } else {
            // tid 알아내서 decrease 후에 increase 하기
            // increase는 공통이므로 밖으로 빼도 되겠다.
            $this->changeResult($uid, $tid, $EISum, $SNSum, $TFSum, $JPSum);
        }
    }
    // getResultInfo 함수 작성
    // deleteResult 함수 작성
}
?>