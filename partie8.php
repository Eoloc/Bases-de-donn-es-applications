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
echo '<form action="action.php" method="post">
 <p>Email utilisateur : <input type="text" name="nom_user" /></p>
 <p>Nom du jeu : <input type="text" name="nom_jeu" /></p>
 <p>Votre commentaire: <input type="text" size="70" name="commentaire" /></p>
 <p><input type="submit" value="OK"></p>
</form>';
