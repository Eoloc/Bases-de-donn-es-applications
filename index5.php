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

//TODO personnalisé le notFound
$container['notFoundHandler'] = function ($container) {
    return function (Request $request, Response $response) {
        return $response->withStatus(404)
            ->withHeader('Content-Type', 'text/html')
            ->write('Page not found');
    };
};


//Les navigateurs font automatiquement l'affichage des json
$app->get('/api/games/{id}', function (Request $req,  Response $res, $args = []) {
    $id=$args['id'];
    $g = Game::where('id', '=', $id )->get();

    $body = $res->getBody();
    $body->write("{$g}");

    return $res->withHeader('Content-Type', 'application/json')->withBody($body);

})->setName('Question1');


$router =$app->getContainer()->get("router");
$app->get('/api/games', function (Request $req,  Response $res, $args = []) {
    if($_GET["page"]== null){
        $tmp = 1;
        $tmp200=200;
        $prev=1;
        $next=2;
    }else{
        $tmp=$_GET["page"]*200;
        $tmp200 = $tmp+200;
        $prev=$_GET["page"]-1;
        $next=$_GET["page"]+1;    
    }
    while($tmp<=$tmp200){
        echo Game::select("id","name","alias","deck")->where("id","=",$tmp)->get();
        echo "\"links\" : { \"self\" : {\"href\" : \"".($GLOBALS["router"]->urlFor("Question1",["id"=>$tmp]))."\"}";
        $tmp++;
    }
    if($tmp>0 && $tmp<239){
        echo"\"links\" : {\"prev\" : {\"href\" : \"/api/games?page=".($prev)."\"}, \"next\" : {\"href\" : \"/api/games?page=".($next)."\"}}";
    }

})->setName('Question2');


try {
    $app->run();
} catch (Throwable $e) {
    echo "<pre>$e</pre>";
}