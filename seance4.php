<?php

use bdd\models\comment;
use bdd\models\comment2game;
use bdd\models\comment2user;
use bdd\models\game;
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

$numberOfGame=  game::count();


for ($i = 0; $i < 25000; $i++){
    $user = new user();

    $email = $faker->unique()->email;
    $user->email    = $email;
    $user->nom      = $faker->lastName;
    $user->prenom   = $faker->firstName;
    $user->adresse  = $faker->address;
    $user->date     = $faker->date($format = 'Y-m-d H:i:s', $max='now');
    $user->numero   = $faker->e164PhoneNumber;
    $user->save();

    for ($j = 0; $j < 10; $j++){
        $com = new comment();
        $com->title    = $faker->words($nb = $faker->randomDigitNotNull, $asText = true);
        $com->content  = $faker->sentences($nb = $faker->numberBetween($min=1, $max=3), $asText = true);
        $com->save();

        $idGame = $faker->numberBetween($min=1, $max=$numberOfGame);

        $c2g = new comment2game();
        $c2g->comment_id = $com->id;
        $c2g->game_id = $idGame;
        $c2g->save();
        $c2g=null;

        $c2u = new comment2user();
        $c2u->comment_id = $com->id;
        $c2u->user_id= $email;
        $c2u->save();
        $c2u=null;

        $com=null;
    }

    $user=null;
}