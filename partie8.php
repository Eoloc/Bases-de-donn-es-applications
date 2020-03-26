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

if(isset($_POST["email"]) and isset($_POST["titre"]) and isset($_POST["contenu"])){
echo "convertion au format JSON...";
//$arr= array(
}
else{/**
echo '<form action="action.php" method="post">
 <p>Email utilisateur : <input type="text" name="email_user" /></p>
 <p>Titre commentaire <input type="text" name="titre_commentaire" /></p>
 <p>Votre commentaire: <input type="text" size="70" name="commentaire" /></p>
 <p><input type="submit" formaction="./partie8.php" value="OK"></p>
</form>';
*/
echo '<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Ajouter un commentaire</legend>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Email</label>  
  <div class="col-md-4">
  <input name="email" class="form-control input-md" id="email" required="" type="text" placeholder="adresse mail">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="titre">Titre</label>  
  <div class="col-md-4">
  <input name="titre" class="form-control input-md" id="titre" required="" type="text" placeholder="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="contenu">Contenu</label>  
  <div class="col-md-4">
  <input name="contenu" class="form-control input-md" id="contenu" required="" type="text" placeholder="message">
    
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="valider"></label>
  <div class="col-md-4">
    <button name="valider" class="btn btn-primary" id="valider">Valider</button>
  </div>
</div>
</fieldset>
</form>';
}
