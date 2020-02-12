<?php

namespace App\Models;

class Migration{

    protected $pdo;

    public function __construct($config){
        if(!empty($config) && is_array($config)){
            $driver = $config['driver'];
            $dbname = $config['dbname'];
            $host = $config['host'];
            $user = $config['user'];
            $password = $config['password'];
            try{
                $this->pdo = new \PDO("$driver:dbname=$dbname;host=$host", $user, $password);
            }catch (\PDOException  $e){
                echo $e->getMessage();
            }

        }
    }

    public function select($tableName, array $selectedFields = array("*"), array $params = array()){
        $fieldsString = implode(',', $selectedFields);
        $query = sprintf("SELECT %s FROM %s", $fieldsString, $tableName);
        if(!empty($params)){

        }

        $prepare = $this->pdo->prepare($query);

        $prepare->execute();

        return $prepare->fetchAll();
    }
}