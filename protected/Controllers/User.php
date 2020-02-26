<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\User as ModelUser;


class User extends Controller{

    public function actionDefault(){

        $dbConfig = $this->app->config->db;
        $userObject = new ModelUser($dbConfig);
    }
}