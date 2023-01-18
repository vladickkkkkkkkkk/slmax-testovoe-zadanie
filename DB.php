<?php
use PDO;

class DB
{
    private $db;
    public $id = 0;
    public $peoplename = '';
    public $surname = '';
    public $dateofbirth = '';
    public $gender = 0;
    public $city = '';
    public function __construct()
    {
        $dbinfo = require '../slmax-testovoe-zadanie/dbinfo.php';
        $this->db = new PDO('mysql:host=' .$dbinfo['host'] . ';dbname=' . $dbinfo['login'], $dbinfo['password']);
    }
    public function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        if(!empty($params))
        {
            foreach($params as $key => $value)
            {
                $stmt->bindValue(":key", $value);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAll($table, $sql= '', $params = [])
    {
        return $this -> query("SELECT * FROM $table" . $sql, $params);
    }
    public function getRow($table, $sql= '', $params = "WHERE id = :id")
    {
        $result = $this->db->prepare("SELECT * FROM $table" . $sql, $params);
		$result = execute([
            'id' => $id,
        ]);
        return $result->fetchAll();
    }
    public static function peopleAge($dateofbirth)
    {
        $d1 = date('Y', strtotime($dateofbirth));
        $d2 = date("Y");
        $dateofbirth = $d2 - $d1;
        return $dateofbirth;
    }
    public static function peopleGender($gender)
    {
        if($gender = 0)
        {
            $gender = 'муж';
        }
        else
        {
            $gender = 'жен':
        }
        return $gender;
    }
    public function peopleEdit($sql= '', $params ='WHERE id = :id')
    {
        $peopleObj = $this->getRow($this->id, $params);
        if ($peopleObj) {
            foreach ($peopleObj as $key => $value) {
                $peopleObj[$key]['dateofbirth'] = $peopleObj[$key][3] = self:: peopleAge($peopleObj[$key]['dateofbirth']);
                $peopleObj[$key]['gender'] = $peopleObj[$key][4] = self:: peopleGender($peopleObj[$key]['gender']);
            }
            return (object) $peopleObj;
        }
    }
    public function peopleAdd($sql = '', $params = [])
    {
        $result = $this -> db -> prepare("INSERT INTO 'people' ( peoplename, surname, dateofbirth, gender, city) VALUES ( :peoplename, :surname, :dateofbirth, :gender, :city)");
        $result->execute([
            'peoplename' => $this->peoplename,
            'surname' => $this->surname,
            'dateofbirth' => $this->dateofbirth,
            'gender' => $this->gender,
            'city' => $this->city,
        ]);
        if(!empty($result))
        {
            return $this -> query("INSERT INTO 'people' ( peoplename, surname, dateofbirth, gender, city) VALUES ( :peoplename, :surname, :dateofbirth, :gender, :city)" . $sql, $params);
        }
        else
        {
            $params = [
                'peoplename' => 'Иван';
                'surname' => 'Иванов';
                'dateofbirth' => '30';
                'gender' => 'муж';
                'city' => 'Moscow';
            ];
            return $this -> query("INSERT INTO 'people' ( peoplename, surname, dateofbirth, gender, city ) VALUES ( :peoplename, :surname, :dateofbirth, :gender, :city )" . $sql, $params);
        }
    }
    public function peopleDelete($sql = '', $params ='WHERE id = :id')
    {
        return $this -> query("DELETE FROM 'people'" . $sql, $params);
    }
}
?>