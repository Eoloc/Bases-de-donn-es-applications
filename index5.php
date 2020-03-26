<?php
use bdd\models\character;
use bdd\models\game;
use bdd\models\company;
use bdd\models\genre;
use Illuminate\Database\Capsule\Manager as DB;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/vendor/autoload.php';

$db = new DB();
$db->addConnection(parse_ini_file('src/conf/conf.ini'));
$db->setAsGlobal();
$db->bootEloquent();
ini_set('memory_limit', '-1');
$s="\n<br>";


//Important pour l'execution de slim et pour afficher les erreurs(pour le dev)
$config = ['settings' => [
    'addContentLengthHeader' => false,
    'displayErrorDetails' => true,
]];
$app = new \Slim\App($config);
$container = $app->getContainer();
$router =$app->getContainer()->get("router");
//TODO personnalisé le notFound
$container['notFoundHandler'] = function ($container) {
    return function (Request $request, Response $response) {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};


// Les navigateurs font automatiquement l'affichage des json
// PARTIE 1
$app->get('/api/games/{id}', function (Request $req,  Response $res, $args = []) {
    $id=$args['id'];
    $g = Game::where('id', '=', $id )->get();

    $body = $res->getBody();
    $body->write("{$g}");

    return $res->withHeader('Content-Type', 'application/json')->withBody($body);

})->setName('Question1');

// PARTIE 2
$router =$app->getContainer()->get("router");
$app->get('/api/games', function (Request $req,  Response $res, $args = []) {

    $body = $res->getBody();

    $body->write("{\n   \"games\":[");

    if($req->getQueryParam('page')== null){
        $tmp = 1;
        $tmp200=200;
        $prev=null;
        $next=1;
    }else{
        $tmp=($req->getQueryParam('page')*200==0)?1:$req->getQueryParam('page')*200;
        $tmp200 = ($tmp==1)?200:$tmp+199;
        $prev=($tmp==1)?null:$req->getQueryParam('page')-1;
        $next=$req->getQueryParam('page')+1;
    }
    while($tmp<=$tmp200){
        $g = Game::select("id","name","alias","deck")->where("id","=",$tmp)->get();
        $tempArray = json_decode($g);

        $name =  trim(preg_replace('/\"/', '\"', $tempArray[0]->name)); //supprime les saut de ligne
        $alias = trim(preg_replace('/\s+/', ' ', $tempArray[0]->alias)); //supprime les saut de ligne
        $deck  = trim(preg_replace('/\s+/', ' ', $tempArray[0]->deck)); //supprime les saut de ligne
        $deck  = trim(preg_replace('/\"/', '\"', $deck)); //remplace " par \"

        $body->write("{
         \"game\": {
            \"id\": \"{$tempArray[0]->id}\",
            \"name\": \"{$name}\",
            \"alias\": \"$alias\",
            \"deck\": \"$deck\"
         },");

        $body->write("
            \"links\": { 
                \"self\": {\"href\" : \"".($GLOBALS["router"]->urlFor("Question1",["id"=>$tmp]))."\"}
            }}");


        $tmp++;

        //Mettre la virgule à tout les élément sauf le dernier
        if($tmp<=$tmp200)
            $body->write(",");
    }
    $body->write("
    ],");

    $body->write("
        \"links\" : {
    ");

    if($prev!==null) {
        $body->write("
            \"prev\" : { \"href\" : \"".($GLOBALS["router"]->urlFor("Question2"))."?page=".($prev)."\"}, 
");
    }

    $body->write("
            \"next\" : {\"href\" : \"".($GLOBALS["router"]->urlFor("Question2"))."?page=".($next)."\"}
        }");

    $body->write("
}");

    return $res->withHeader('Content-Type', 'application/json')->withBody($body);


    //TODO
    /*



     */
})->setName('Question2');

//PARTIE 5
$app->get("/api/games/{id}/comments",function (Request $req,  Response $res, $args = []){
    $id =$args['id'];
});

//PARTIE 7
$app->get("/api/games/{id}/characters",function (Request $req,  Response $res, $args = []) {
     $id=$args['id'];
    foreach (Game::where('id', '=', $id)->get() as $game) {
        foreach ($game->characters as $ch) {
            $tmp = $ch->id;
            echo "{\"character\" : {\"id\":".$ch->id . ",\"name\": " . $ch->name.","."},"."\"links\":{ \"self\" : {\"href\" : \"".($GLOBALS["router"]->urlFor("Commentaires",["id"=>$tmp]))."\"}}}"  ;
        }
        echo $s;
}
    
})->setName("Personnages");

$app->get("/api/characters/{id}", function (Request $req,  Response $res, $args = []){
    $id=$args['id'];
    foreach (Character::where('id', '=', $id)->get() as $c) {
        echo "{\"character\" : {\"id\":".$c->id . ",\"name\": " . $c->name.",\"deck\": ".$c->deck."}";
    }
})->setName("Commentaires");

try {
    $app->run();
} catch (Throwable $e) {
    echo "<pre>$e</pre>";
}