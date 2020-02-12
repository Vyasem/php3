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

    public function up(){
        $query = file_get_contents($_SERVER['DOCUMENT_ROOT']."/migration/up_1.sql");
        try{
            $prepareQuery = $this->pdo->prepare($query);
            $prepareQuery->execute();
        }catch(\Exception $e){
            echo $e->getMessage();
        }
    }
}