<?php

namespace App\Controllers;

use T4\Mvc\Controller;
use App\Models\Migration;

class Index extends Controller
{
    public function actionDefault()
    {
        $configArray = $this->app->config->getData();
        $dbConfig = $configArray['db']->getData();
        $migration = new Migration($dbConfig);
        $migration->up(2);
        $this->data['domain'] = $configArray['domain'];
        $this->data['title'] = 'Home page of '.$configArray['domain'];
    }

}