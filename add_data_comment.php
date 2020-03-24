<?php

use bdd\models\comment;
use bdd\models\comment2game;
use bdd\models\comment2user;
use bdd\models\user;
use Illuminate\Database\Capsule\Manager as DB;

require_once __DIR__ . '/vendor/autoload.php';

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();

$user = new user();
$user->email    = "roblox@jeu.fr";
$user->nom      = "Mi";
$user->prenom   = "Jean";
$user->adresse  = "38 Rue de la Librairie, 42666, FRANCE";
$user->date     = "2020-03-01";
$user->save();

$user2 = new user();
$user2->email    = "ytp@youtube.fr";
$user2->nom      = "Milos";
$user2->prenom   = "Ricardo";
$user2->adresse  = "Internet";
$user2->date     = '2000-01-01';
$user2->save();


$comm11 = new comment();
$comm11->title   = 'Bien';
$comm11->content = 'C\'est bien';
$comm11->save();

$comm12 = new comment();
$comm12->title   = 'Nan mais vraiment';
$comm12->content = 'C\'est bien';
$comm12->save();

$comm13 = new comment();
$comm13->title   = 'J\'aime';
$comm13->content = 'J\'adore rire';
$comm13->save();

$c2g11 = new comment2game(); $c2g11->comment_id=1; $c2g11->game_id=12342; $c2g11->save();
$c2u11 = new comment2user(); $c2u11->comment_id=1; $c2u11->user_id='roblox@jeu.fr'; $c2u11->save();

$c2g12 = new comment2game(); $c2g12->comment_id=2; $c2g12->game_id=12342; $c2g12->save();
$c2u12 = new comment2user(); $c2u12->comment_id=2; $c2u12->user_id="roblox@jeu.fr"; $c2u12->save();

$c2g13 = new comment2game(); $c2g13->comment_id=3; $c2g13->game_id=12342; $c2g13->save();
$c2u13 = new comment2user(); $c2u13->comment_id=3; $c2u13->user_id="roblox@jeu.fr"; $c2u13->save();



$comm21 = new comment();
$comm21->title   = 'NUL';
$comm21->content = 'C\'est pas bien';
$comm21->save();

$comm22 = new comment();
$comm22->title   = 'Nan mais vraiment';
$comm22->content = 'C\'est nul';
$comm22->save();

$comm23 = new comment();
$comm23->title   = 'J\'aime pas';
$comm23->content = 'J\'adore vendre';
$comm23->save();

$c2g21 = new comment2game(); $c2g21->comment_id=4; $c2g21->game_id=12342; $c2g21->save();
$c2u21 = new comment2user(); $c2u21->comment_id=4; $c2u21->user_id="ytp@youtube.fr"; $c2u21->save();

$c2g22 = new comment2game(); $c2g22->comment_id=5; $c2g22->game_id=12342; $c2g22->save();
$c2u22 = new comment2user(); $c2u22->comment_id=5; $c2u22->user_id="ytp@youtube.fr"; $c2u22->save();

$c2g23 = new comment2game(); $c2g23->comment_id=6; $c2g23->game_id=12342; $c2g23->save();
$c2u23 = new comment2user(); $c2u23->comment_id=6; $c2u23->user_id="ytp@youtube.fr"; $c2u23->save();