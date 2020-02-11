<?php

namespace App\Controllers;

use T4\Mvc\Controller;

class Index
    extends Controller
{

    public function actionDefault()
    {
        $configArray = $this->app->config->getData();
        $this->data['domain'] = $configArray['domain'];
        $this->data['title'] = 'Home page of '.$configArray['domain'];
    }
}