<?php

use bdd\models\user;
use Faker\Factory;
use Illuminate\Database\Capsule\Manager as DB;


require_once __DIR__ . '/vendor/autoload.php';
$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();
$faker = Factory::create('en_US');

ini_set('max_execution_time', '300');
ini_set('request_terminate_timeout', '300');

//echo "augmenter le max_execution_time";
//sleep(2);

for ($i = 0; $i < 25000; $i++){
    $user = new user();
    $user->email    = $faker->unique()->email;
    $user->nom      = $faker->lastName;
    $user->prenom   = $faker->firstName;
    $user->adresse  = $faker->address;
    $user->date     = $faker->date($format = 'Y-m-d H:i:s', $max='now');
    $user->numero   = $faker->e164PhoneNumber;
    $user->save();
    $user=null;
}