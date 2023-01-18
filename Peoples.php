<?php
use PDO;
require_once 'DB.php';
if(!require_once 'DB.php')
{
    echo "Error";
}
class Peoples
{
    private $db;
    $db1 = new DB();
    public $list;
    public function __construct($sql= '', $params = [])
    {
        $dbinfo = require '../slmax-testovoe-zadanie/dbinfo.php';
        $this->db = new PDO('mysql:host=' .$dbinfo['host'] . ';dbname=' . $dbinfo['login'], $dbinfo['password']);
        $params = [
            "WHERE peoplename = :peoplename OR surname = :surname OR dateofbirth = :dateofbirth OR gender = :gender OR city = :city"
        ];
        $list = $this->$db1->getAll($params);
        $params = [
            'id' => $this->id,
        ];
        $list = $this->$db1->peopleDelete($params);
    }
}
?>