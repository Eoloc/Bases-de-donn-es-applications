<?php

use bdd\models\company;
use bdd\models\game;
use bdd\models\platform;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();
ini_set('memory_limit', '-1');

$s="\n<br>";

//Q1
/*
echo "Liste de jeu contenant le nom mario$s$s";
foreach (game::where('name', 'like', "%mario%")->get() as $n){
    echo "$n->name$s";
}
*/

//Q2
/*
echo "Liste des companies résidant au japon:$s$s";
foreach (company::where('location_country', 'like', 'japan')->get() as $n){
    echo "$n->name$s";
}
*/

//Q3
/*
echo "lister les plateformes dont la base installée est >= 10 000 000:$s$s";
foreach (json_decode(platform::where('install_base', '>=', 10000000)->get()) as $n){
    echo "$n->name$s";
}
*/

//Q4
/*
echo "lister 442 jeux à partir du 21173ème:$s$s";
foreach (json_decode(game::limit(412)->offset(21172)->get()) as $n){
    echo "$n->name$s";
}
*/

//Q5
/*
echo "lister les jeux, afficher leur nom et deck, en paginant (taille des pages : 500):$s$s";
$i=0; $p=1;
foreach (json_decode(game::get()) as $n){
    $i++;
    echo "$n->name et $n->deck$s";
    if($i>=500){
        echo "$s$s$p$s$s";
        $p++;
        $i=0;
    }
}
echo $p;
*/