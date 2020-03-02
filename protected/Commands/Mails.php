<?php


namespace App\Commands;

use T4\Console\Command;


class Mails extends Command{
    public function actionDefault(){
        $viewCount =  $_SERVER['argv'][2];

        $to = "vyasem@gmail.com";
        $subject = "View count";
        $message = "View count of your site: $viewCount";
        $result = mail($to, $subject, $message);
        $this->writeLn($result);

        //cron schedule
        //*/30 * * * *
    }
}