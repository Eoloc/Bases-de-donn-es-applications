<?php

use bdd\models\company;
use bdd\models\game;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';
$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

ini_set('memory_limit', '1G');


$s="<br>\n";

// Q1.1
// $start=microtime(true);
// $res1 = Game::get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res1 as $game) {
//     echo $game->name . $s;
// }

// Q1.2
// $start=microtime(true);
// $res2 = Game::where('name', 'like', '%Mario%')->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res2 as $game) {
//    echo $game->name . $s;
// }

// Q1.3
// $start=microtime(true);
// $res3 = Game::where('name', 'like', 'Mario%')->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res3 as $game) {
//     echo $game->name . $s;
//     foreach ($game->characters as $ch) {
//         echo '--- '.$ch->id . '. ' . $ch->name . ' : '.$ch->deck . $s ;
//     }
//     echo $s;
// }

// Q1.4
// $start=microtime(true);
// $res4 = Game::where('name', 'like', 'Mario%')
//    ->whereHas('original_game_ratings', function($q){
//        $q->where('name', 'like', '%3+%');
//    })
//    ->whereHas('publishers', function($q) {
//        $q->where('name', 'like', '%Inc.%');
//    })

//    ->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res4 as $game) {
//    echo '#### ' . $game->name . ' : ' . $game->id . $s;
//    foreach ($game->original_game_ratings as $rating) {
//        echo '-------- ' . $rating->name . $s;
//    }
//    foreach ($game->publishers as $comp) {
//        echo '--> publisher : '. $comp->name .  $s;
//    }
// }

echo "PARTIE 1 $s $s";
echo "Cache de requêtes MYSQL" . $s;
echo "Lorsque l'on relance la même requête, le temps d'execution
 diminue" . $s . $s;

//Q1.1
// $start=microtime(true);
// $res11 = Game::where('name', 'like', 'Ancient Egyptian Mehen%')->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res11 as $game) {
//    echo $game->name . $s;
// }

echo "Index SQL" . $s;
echo "Lorsqu'on lance la requête avec un where différent, 
le temps d'execution varie selon la quantité de donnée qui 
doit être traitée" . $s . $s;

//Q1.3  après avoir add l'index sur la table game
// $start=microtime(true);
// $res13 = Game::where('name', 'like', '%Mario%')->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res13 as $game) {
//    echo $game->name . $s;
// }

echo "Après voir add un index a la table,
 on gagne 2 secondes environs sur le temps d'execution de la requête.
 Le temps d'execution varie toujours selon la quantité de donnée a traiter" . $s . $s;

echo "PARTIE 2 $s $s";

// On active dans Eloquent le mécanisme de log de requêtes
DB::connection()->enableQueryLog();


//Q2.1
// $start=microtime(true);
// $res21 = Game::where('name', 'like', '%Mario%')->get();
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo $s . "1 requête a été exécutée" . $s . $s;

//Q2.2
// $start=microtime(true);
// $res22 = Game::where('id', '=', '12342')->get();
// $countRequest = 1;
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res22 as $game) {
//     foreach ($game->characters as $ch) {
//     }
//     $countRequest++;
// }
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo $s . $countRequest . " requêtes ont été exécutées" . $s . $s;


//Q2.3
// $start=microtime(true);
// $res23 = Game::where('name', 'like', '%Mario%')->get();
// $countRequest = 1;
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// foreach ($res23 as $game) {
//     foreach ($game->first_appearance_characters as $ch) {
//     }
//     $countRequest++;
// }
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo $s . $countRequest . " requêtes ont été exécutées" . $s . $s;

//Q2.4
// $start=microtime(true);
// $res24 = Game::where('name', 'like', '%Mario%')->get();
// $time = microtime(true)-$start;
// $countRequest = 1;
// echo $time . $s . $s;
// foreach ($res24 as $game) {
//     foreach ($game->characters as $ch) {
//     }
//     $countRequest++;
// }
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo $s . $countRequest . " requêtes ont été exécutées" . $s . $s;

//Q2.5
// echo "Compagnie dont le nom contient Sony avec leurs jeux $s $s";
// $start=microtime(true);
// $res25 = company::where('name','LIKE', '%Sony%')->get();
// $time = microtime(true)-$start;
// $countRequest = 1;
// foreach ($res25 as $company) {
//     foreach ($company->developpedBy as $game) {
//     }
//     $countRequest++;
// }
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo $s . $countRequest . " requêtes ont été exécutées" . $s . $s;

//Q Chargement liés
// $start=microtime(true);
// $games = Game::where('name', 'like', 'Mario%')->with('characters')->get();
// $countRequest = 1;
// foreach ($games as $game) {
//     foreach($game->characters as $ch) {
//     }
// }
// $time = microtime(true)-$start;
// echo $time . $s . $s;
// $queries = DB::getQueryLog();
// $last_query = end($queries);
// var_dump($last_query);
// echo "$s $s Il n'y a qu'une requête faite ici car with fait en fait
// un inner join reliant la table game a la table characters";