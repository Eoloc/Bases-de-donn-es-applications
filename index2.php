<?php

use bdd\models\character;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();
ini_set('memory_limit', '-1');
$s="\n<br>";

//Q1
echo "Noms et decks des personnages du jeu 12342 <br>";
$t = character::find(1);
var_dump($t);

/*
foreach ($table as $n){
    echo "$n->name$s";
}
*/