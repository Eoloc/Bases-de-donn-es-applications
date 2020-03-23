<?php


use bdd\models\game;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';
$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

ini_set('memory_limit', '1G');


$s="<br>\n";

//Q1
//$start=microtime(true);
//$res1 = Game::get();
//$time = microtime(true)-$start;
//echo $time . $s . $s;
// foreach ($res1 as $game) {
//     echo $game->name . $s;
// }

//Q2
//$start=microtime(true);
//$res2 = Game::where('name', 'like', '%Mario%')->get();
//$time = microtime(true)-$start;
//echo $time . $s . $s;
//foreach ($res2 as $game) {
//    echo $game->name . $s;
//}

//Q3
//$start=microtime(true);
//$res3 = Game::where('name', 'like', 'Mario%')->get();
//$time = microtime(true)-$start;
//echo $time . $s . $s;
// foreach ($res3 as $game) {
//     echo $game->name . $s;
//     foreach ($game->characters as $ch) {
//         echo '--- '.$ch->id . '. ' . $ch->name . ' : '.$ch->deck . $s ;
//     }
//     echo $s;
// }

//Q4
$start=microtime(true);
$res4 = Game::where('name', 'like', 'Mario%')
    ->whereHas('original_game_ratings', function($q){
        $q->where('name', 'like', '%3+%');
    })
    ->whereHas('publishers', function($q) {
        $q->where('name', 'like', '%Inc.%');
    })

    ->get();
$time = microtime(true)-$start;
echo $time . $s . $s;
foreach ($res4 as $game) {
    echo '#### ' . $game->name . ' : ' . $game->id . $s;
    foreach ($game->original_game_ratings as $rating) {
        echo '-------- ' . $rating->name . $s;
    }
    foreach ($game->publishers as $comp) {
        echo '--> publisher : '. $comp->name .  $s;
    }
}
