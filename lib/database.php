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

    function getClassList()
    {
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
}
?>

</html> 