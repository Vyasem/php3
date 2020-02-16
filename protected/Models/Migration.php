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
        $itemMigration = "1";
        if(!empty($this->getLastMigration())){
            $itemMigration = $this->getLastMigration();
            ++$itemMigration;
        }
        $queryFile = __DIR__ . "/../../migration/up_$itemMigration.sql";
        $result = $this->run($queryFile);
        if($result){
            $this->updateMigrationHistory($itemMigration);
        }

        return $result;

    }

    public function down(){
        $itemMigration = "1";
        if(!empty($this->getLastMigration)){
            $itemMigration = $this->getLastMigration;
        }

        $queryFile =  __DIR__ . "/../../migration/down_$itemMigration.sql";
        return $this->run($queryFile);
    }

    protected function run($queryFile){
        if(!is_readable($queryFile))
            return false;

        $query = file_get_contents($queryFile);

        $prepareQuery = $this->pdo->prepare($query);
        return $prepareQuery->execute();
    }

    protected function getLastMigration(){
        $query = sprintf("SELECT %s FROM %s ORDER BY %s DESC", 'last_migration', 'm_history', 'last_migration');
        $prepareQuery = $this->pdo->prepare($query);
        $prepareQuery->execute();
        $result = $prepareQuery->fetch();
        return $result['last_migration'];
    }

    protected function updateMigrationHistory($migration){
        $query = "INSERT INTO m_history (last_migration) VALUES ($migration)";
        $prepareQuery = $this->pdo->prepare($query);
        return $prepareQuery->execute();
    }
}