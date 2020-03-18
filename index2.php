<?php

use bdd\models\character;
use bdd\models\game;
use bdd\models\company;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();
ini_set('memory_limit', '-1');
$s="\n<br>";

//Q1
// echo "Noms et decks des personnages du jeu 12342 \n<br>\n<br>";
// foreach (Game::where('id', '=', '12342')->get() as $game) {
//     echo $game->name . $s;
//     foreach ($game->characters as $ch) {
//         echo '--- '.$ch->id . '. ' . $ch->name . ' : '.$ch->deck . $s ;
//     }
//     echo $s;
// }

//Q2
// echo "Personnages des jeux dont le nom (du jeu) débute par Mario : \n<br>\n<br>";
// foreach (Game::where('name', 'like', 'Mario%')->get() as $game) {
//     echo $game->name . $s;
//     foreach ($game->characters as $ch) {
//         echo '--- '.$ch->id . '. ' . $ch->name . ' : '.$ch->deck . $s ;
//     }
//     echo $s;
// }


//Q3
echo "Compagnie dont le nom contient Sony avec leurs jeux\n<br>\n<br>";
foreach (company::where('name','LIKE', '%Sony%')->get() as $company) {
    echo $company->name . $s;
    foreach ($company->developpedBy as $game) {
        
        echo '--- '. $game->id . '. ' . $game->name . $s ;
    }
    echo $s;
}


//Q6
echo "Jeux dont le nom débute par Mario et dont le rating est superieur à 3 \n<br>\n<br>";
foreach (Game::where('name', 'like', 'Mario%')->get() as $game) {
    foreach ($game->original_game_ratings as $ra) {
        if(strpos($ra->name,"3+")!==false){
            echo $game->name . $s;
            echo '--- '.$ra->name . $s.$s ;
        }
    }
}