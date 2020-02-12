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

    public function up($number = 1){
        $query = file_get_contents("{$_SERVER['DOCUMENT_ROOT']}/migration/up_$number.sql");

        try{
            $prepareQuery = $this->pdo->prepare($query);
            var_dump($prepareQuery);
            $prepareQuery->execute();
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}