<?php

namespace App\Models;

class Migration{

    protected $pdo;
    protected $dbname;

    public function __construct($config){
        if(!empty($config) && is_array($config)){
            $driver = $config['driver'];
            $dbname = $config['dbname'];
            $host = $config['host'];
            $user = $config['user'];
            $password = $config['password'];

            $this->dbname = $dbname;

            try{
                $this->pdo = new \PDO("$driver:dbname=$dbname;host=$host", $user, $password);
            }catch (\PDOException  $e){
                echo $e->getMessage();
            }
        }
    }

    /*применить миграцию*/
    public function up(){
        $itemMigration = "1";
        if(!empty($this->getLastMigration())){
            $itemMigration = $this->getLastMigration();
            ++$itemMigration;
        }

        $queryFile = __DIR__ . "/../../migration/up_$itemMigration.sql";

        /*Если DROP TABLE то подготовить откат*/
        $this->prepareBackup($queryFile, $itemMigration);

        $result = $this->run($queryFile);

        if($result){
            $this->updateMigrationHistory($itemMigration);
        }

        return $result;

    }

    /*откатить миграцию*/
    public function down($migrationNumber){
        $queryFile =  __DIR__ . "/../../migration/down_$migrationNumber.sql";
        return $this->run($queryFile);
    }

    /*выполнение запроса*/
    protected function run($queryFile){
        if(!is_readable($queryFile))
            return false;

        $query = file_get_contents($queryFile);

        $prepareQuery = $this->pdo->prepare($query);
        return $prepareQuery->execute();
    }

    /*получаем последнюю миграцию*/
    protected function getLastMigration(){
        $query = sprintf("SELECT %s FROM %s ORDER BY %s DESC", 'last_migration', 'm_history', 'last_migration');
        $prepareQuery = $this->pdo->prepare($query);
        $prepareQuery->execute();
        $result = $prepareQuery->fetch();
        return $result['last_migration'];
    }

    /*добавляем информацию о последней мигрии*/
    protected function updateMigrationHistory($migration){
        $query = sprintf("INSERT INTO %s (%s) VALUES (%s)", "m_history", "last_migration", $migration);
        $prepareQuery = $this->pdo->prepare($query);
        return $prepareQuery->execute();
    }

    /*Подготовка запросов для восстановления удаленной базы и сохранение их в файл*/
    protected function prepareBackup($queryFile, $number){
        if(!is_readable($queryFile))
            return false;

        $query = file_get_contents($queryFile);
        $arQuery = explode(' ', $query);

        foreach($arQuery as $key => $item){
            if($item == 'DROP'){
                $table = $arQuery[$key + 2];
            }
        }

        if(!empty($table)){

            $arrayCreate = $this->runQuery(sprintf("SHOW CREATE TABLE %s.%s", $this->dbname, $table));
            $arraySelect = $this->runQuery(sprintf("SELECT * FROM %s", $table));

            $insertQuery = '';
            foreach($arraySelect as $itemField){
                $insetCols = [];
                $insertValues = [];
                foreach($itemField as $key => $item){
                    $insetCols[] = $key;
                    $insertValues[] = $item;
                }
                $insetCols = implode(',', $insetCols);
                $insertValues = implode("','", $insertValues);
                $insertQuery .= sprintf("INSERT INTO %s (%s) VALUES ('%s'); \n", $table, $insetCols, $insertValues);
            }

            file_put_contents(__DIR__ . "/../../migration/down_$number.sql", $arrayCreate[0]["Create Table"].";\n");
            file_put_contents(__DIR__ . "/../../migration/down_$number.sql", $insertQuery, FILE_APPEND);
        }

        return true;
    }

    protected function runQuery($query){
        $prepareQuery = $this->pdo->prepare($query);
        $prepareQuery->execute();
        return $prepareQuery->fetchAll(\PDO::FETCH_ASSOC);
    }
}