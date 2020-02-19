<?php

use \T4\Core\Config;
use App\Models\Migration;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../protected/boot.php';
require __DIR__ . '/../protected/autoload.php';

$configArray = new Config( __DIR__ . '/../protected/config.php');
$config = $configArray->getData();
$dbConfig = $config['db']->getData();

$new = new Migration($dbConfig);
while($new->up()){
    $new->up();
}
$new->down(3);

echo "Successful! \n";
