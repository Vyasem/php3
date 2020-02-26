<?php

namespace App\Models;

use T4\Orm\Model;
use T4\Dbal\Connection;
use T4\Dbal\Query;


class User extends Model{

    protected $firstName, $lastName, $middleName, $role;
    protected $db;

    public function __construct(/*$dbconfig*/){
        /*$connection = new Connection($dbconfig);
        $query = new Query(['action' => 'select', 'columns' =>'id, name', 'tables' => 'users']);
        $prepareQuery = $connection->query($query);
        $result = $prepareQuery->fetchAll(\PDO::FETCH_ASSOC);*/
    }

    public function getName($firstName = 0, $middleName = 0, $lastName = 0, $email = 0){
        if(!empty($firstName) && !empty($lastName) && !empty($middleName)){
            return  trim($firstName) .' ' . trim($middleName) . ' '. trim($lastName);
        }else if(!empty($firstName) && !empty($lastName)){
            return trim($firstName) . ' ' . trim($lastName);
        }else{
            return trim($email);
        }
    }
}