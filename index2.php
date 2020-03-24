<?php

use bdd\models\character;
use bdd\models\game;
use bdd\models\company;
use bdd\models\genre;
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
// echo "Compagnie dont le nom contient Sony avec leurs jeux\n<br>\n<br>";
// foreach (company::where('name','LIKE', '%Sony%')->get() as $company) {
//     echo $company->name . $s;
//     foreach ($company->developpedBy as $game) {    
//         echo '--- '. $game->id . '. ' . $game->name . $s ;
//     }
//     echo $s;
// }

//Q4
// echo "le rating initial (indiquer le rating board) des jeux  dont le nom contient Mario";
// foreach (Game::where('name', 'like', 'Mario%')->get() as $game) {
// echo '---- '. $game->name . ' : ' . $game->id . $s;
//         foreach ($game->original_game_ratings as $rating) {
//             echo '####### '. $rating->name . ' ('. $rating->rating_board->name . ')'.$s;
//         }
//     }

//Q5
// echo "Jeux dont le nom débute par Mario et ayant plus de 3 personnages \n<br>\n<br>";
// foreach (Game::where('name', 'like', 'Mario%')->has('characters', '>', 3)->get() as $game) {
//    echo $game->name . ' : ' . $game->id . "\n";
//    foreach ($game->characters as $ch) {
//        echo '--- '.$ch->id . '. ' . $ch->name . ' : '.$ch->deck . "\n" ;
//    }
// }


//Q6
// echo "Jeux dont le nom débute par Mario et dont le rating initial contient '3+' \n<br>\n<br>";
// foreach (Game::where('name', 'like', 'Mario%')->get() as $game) {
//     foreach ($game->original_game_ratings as $ra) {
//         if(strpos($ra->name,"3+")!==false){
//             echo $game->name . $s;
//             echo '--- '.$ra->name . $s.$s ;
//         }
//     }
// }

//Q7
// echo "Jeux dont le nom débute par Mario, créé par une compagnie dont le nom contient Inc et qui possède un rating initial contient '3+' $s $s";

// foreach (Game::where('name','LIKE', 'Mario%')
//     ->whereHas('original_game_ratings', function($q) {
//         $q->where('name', 'like', '%3+%');
//     })
//     ->whereHas('publishers', function($q) {
//         $q->where('name', 'like', '%Inc%');
//     })
//     ->get() as $game) {
//     foreach ($game->publishers as $company) {
//         echo '- '. $company->name . " : " . $s;
//     }
//     echo '--- '.$game->name .' - ';
//     foreach($game->original_game_ratings as $rating) {
//         if($rating->name === 'PEGI: 3+') 
//             echo $rating->name;
//     }
//     echo $s . $s;
// }


//Q8
//  echo "Les jeux dont le nom contient Mario, publiés par une compagnie dont le nom contient Inc, dont le rating initial contient 3+ et ayant reçu un avis de du rating board nommé CERO".$s.$s;
// foreach (Game::where('name', 'like', 'Mario%')
//             ->whereHas('original_game_ratings', function($q){
//                  $q->where('name', 'like', '%3+%');
//             })
//             ->whereHas('publishers', function($q) {
//                 $q->where('name', 'like', '%Inc.%');
//             })
//             ->orwhereHas('original_game_ratings', function($q){
//                  $q->where('name', '=', 'CERO%');
//             })
//             ->get() as $game) {
//     echo '--- ' . $game->name . ' : ' . $game->id . "$s";
//     foreach ($game->original_game_ratings as $rating) {
//         echo '------ ' . $rating->name . "$s";
//     }
//     foreach ($game->publishers as $comp) {
//         echo '------ Publisher : '. $comp->name .  "$s";
//     }
// }


//Q9
//insert into genre values (51 , 'nouveau genre' , NULL , 'cest le genre nouveau');

$genre=new genre();
$genre->name='nouvo Genre';
$genre->description='la description du genre nouveau';
$genre->save();
echo $genre->id;
$genre->modifierJeu(12,$genre->id);
$genre->modifierJeu(56,$genre->id);
$genre->modifierJeu(345,$genre->id);
