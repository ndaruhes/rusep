<?php

class Database
{
    private static $koneksiDatabase = null;
    private $connect,
        $host = 'localhost',
        $user = 'root',
        $password = '',
        $db_name  = 'aplikasi_share_cooking_app_dugam';

    public function __construct()
    {
        try {
            $this->connect = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->user, $this->password);
            $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Failed To Connect Server Because ' . $e->getMessage());
        }
    }

    public static function koneksiDatabase()
    {
        if (!isset(self::$koneksiDatabase)) {
            self::$koneksiDatabase = new Database();
        }
        return self::$koneksiDatabase;
    }

    public function readData($table, $key, $value)
    {
        if ($key == '' && $value == '') {
            $statement = $this->connect->prepare("SELECT * FROM $table");
            $statement->execute();
            while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
                $result[] = $data;
            }
            return $result;
        } else {
            $statement = $this->connect->prepare("SELECT * FROM $table WHERE $key='$value'");
            $statement->execute();
            $data = $statement->fetch(PDO::FETCH_OBJ);
            // print_r($statement); die();
            return $data;
        }
    }

    public function insertData($table, $fields = [])
    {
        $bungkusNilai = [];
        $i = 0;
        foreach ($fields as $column => $content) {
            if (!is_int($content)) {
                $bungkusNilai[] = "'" . $content . "'";
            } else {
                $bungkusNilai[] = $content;
            }
            $i++;
        }
        $column = implode(", ", array_keys($fields));
        $content = implode(", ", $bungkusNilai);
        $statement = $this->connect->prepare("INSERT INTO $table($column) VALUES($content)");
        // print_r($statement);die();
        $statement->execute();
    }

    public function updateData($table, $fields = array(), $key, $value)
    {
        $bungkusNilai = array();
        $i = 0;

        foreach ($fields as $column => $nilai) {
            if (!is_int($nilai)) {
                $bungkusNilai[] = $column . "='" . $nilai . "'";
            } else {
                $bungkusNilai[] = $column . "=" . $nilai;
            }
            $i++;
        }
        if (!is_int($value)) {
            $value = "'" . $value . "'";
        }
        $result = implode(", ", $bungkusNilai);

        $statement = $this->connect->prepare("UPDATE $table SET $result WHERE $key=$value");
        // print_r($statement);die();
        $statement->execute();
    }

    public function checkData($table, $key, $value)
    {
        if ($key == '' && $value == '') {
            $statement = $this->connect->prepare("SELECT * FROM $table");
            $statement->execute();
            $data = $statement->rowCount();
            return $data;
        } else {
            $statement = $this->connect->prepare("SELECT * FROM $table WHERE $key='$value'");
            $statement->execute();
            $data = $statement->rowCount();
            return $data;
        }
    }

    public function readJoinData($table1, $table2, $column1, $column2, $key, $value)
    {
        if ($key == '' && $value == '') {
            $statement = $this->connect->prepare("SELECT * FROM $table1 A JOIN $table2 B ON A.$column1 = B.$column2");
            // print_r($statement);die();
            $statement->execute();
            while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
                $result[] = $data;
            }
            return $result;
        } else {
            $statement = $this->connect->prepare("SELECT * FROM $table1 A JOIN $table2 B ON A.$column1 = B.$column2 WHERE $key='$value'");
            // print_r($statement);die();
            $statement->execute();
            while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
                $result[] = $data;
            }
            return $result;
        }
    }

    public function readJoinDataThree($table1, $table2, $column1, $column2, $table3, $column3, $column4, $key, $value)
    {
        if ($key == '' && $value == '') {
            $statement = $this->connect->prepare("SELECT * FROM $table1 A JOIN $table2 B ON A.$column1 = B.$column2 JOIN $table3 C ON A.$column3 = C.$column4");
            // print_r($statement);die();
            $statement->execute();
            while ($data = $statement->fetch(PDO::FETCH_OBJ)) {
                $result[] = $data;
            }
            return $result;
        } else {
            $statement = $this->connect->prepare("SELECT * FROM $table1 A JOIN $table2 B ON A.$column1 = B.$column2 JOIN $table3 C ON A.$column3 = C.$column4 WHERE $key='$value'");
            // print_r($statement);die();
            $statement->execute();
            $data = $statement->fetch(PDO::FETCH_OBJ);
            return $data;
        }
    }

    public function deleteData($table, $key, $value)
    {
        if (!is_int($value)) {
            $value = "'" . $value . "'";
        }
        $statement = $this->connect->prepare("DELETE FROM $table WHERE $key=$value");
        $statement->execute();
    }
}
