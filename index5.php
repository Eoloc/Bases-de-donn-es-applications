<?php
use bdd\models\character;
use bdd\models\game;
use bdd\models\company;
use bdd\models\genre;
use bdd\models\platform;
use bdd\models\comment;
use bdd\models\comment2user;
use bdd\models\comment2game;
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

$app->get('/test', function (Request $req,  Response $res, $args = []) {
    $g = Game::select("id","name","alias","deck")->where('id', '=', '35444')->with('characters')->get();
    // var_dump($g);
    // $tempArray = json_decode($g);
    // $platforms = $tempArray[0]->platforms;
    // $tempArrayPlatform = $tempArray;
    $body = $res->getBody();
    // for($i = 0; $i < count($platforms); $i++) {
    //     // $body->write();
    // }
    $body->write("{$g}");
    // for($i = 0; $i < count($tempArray[0]->platforms); $i++) {
    // }
    return $res->withHeader('Content-Type', 'application/json')->withBody($body);

})->setName('test');

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
        $g = Game::select("id","name","alias","deck")->where("id","=",$tmp)->with('platforms')->get();
        $tempArray = json_decode($g);

        $id = $tempArray[0]->id;
        $name =  trim(preg_replace('/\"/', '\"', $tempArray[0]->name)); //supprime les saut de ligne
        $alias = trim(preg_replace('/\s+/', ' ', $tempArray[0]->alias)); //supprime les saut de ligne
        $deck  = trim(preg_replace('/\s+/', ' ', $tempArray[0]->deck)); //supprime les saut de ligne
        $deck  = trim(preg_replace('/\"/', '\"', $deck)); //remplace " par \"
        $platforms = $tempArray[0]->platforms;


        $body->write("
        {
            \"game\": {
                \"id\": \"{$id}\",
                \"name\": \"{$name}\",
                \"alias\": \"$alias\",
                \"deck\": \"$deck\",
                \"platforms\": [");
            for($i = 0; $i < (count($platforms)-1); $i++) {
                $aliasPlatform = trim(preg_replace('/\s+/', ' ', $platforms[$i]->alias)); //supprime les saut de ligne
                $body->write("{
                    \"id\": \"{$platforms[$i]->id}\",
                    \"name\": \"{$platforms[$i]->name}\",
                    \"alias\": \"$aliasPlatform\",
                    \"abbreviation\": \"{$platforms[$i]->abbreviation}\",
                    \"url\": \"".($GLOBALS["router"]->urlFor("Question6",["id"=>$platforms[$i]->id]))."\"
                },");
            }
            if(count($platforms) != 0) {
                $aliasPlatform = trim(preg_replace('/\s+/', ' ', $platforms[$i]->alias));
                $body->write("{
                    \"id\": \"{$platforms[(count($platforms) - 1)]->id}\",
                    \"name\": \"{$platforms[(count($platforms) - 1)]->name}\",
                    \"alias\": \"$aliasPlatform\",
                    \"abbreviation\": \"{$platforms[(count($platforms) - 1)]->abbreviation}\",
                    \"url\": \"".($GLOBALS["router"]->urlFor("Question6",["id"=>$platforms[(count($platforms) - 1)]->id]))."\"
                }");
            }
            $body->write("]
            },");

        $body->write("
            \"links\": { 
                    \"self\": {\"href\": \"".($GLOBALS["router"]->urlFor("Question1",["id"=>$tmp]))."\"},
                    \"comments\": {\"href\": \"".($GLOBALS["router"]->urlFor("Question1",["id"=>$tmp]))."/comments\"},
                    \"characters\": {\"href\": \"".($GLOBALS["router"]->urlFor("Question1",["id"=>$tmp]))."/characters\"}
                }
        }");


        $tmp++;

        //Mettre la virgule à tout les élément sauf le dernier
        if($tmp<=$tmp200)
            $body->write(",
            ");
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

//PARTIE 8
$app->post("/api/games/{id}/comments",function (Request $req,  Response $res, $args = []){
    $id =$args['id'];
	echo "lol";
	$jsonData = file_get_contents("php://input");
	var_dump($jsonData);
	$decode=json_decode($jsonData);
        $email=$decode->{'email'};
	$titre=$decode->{'titre'};
        $commentaire=$decode->{'commentaire'};
	var_dump($decode);

	$c=new Comment();
	$c->title=$titre;
	$c->content=$commentaire;
	//$c->save();


	$c2u=new Comment2user();
	$c2u->comment_id=$c->id;
	$c2u->user_id=$id;
	//$c2u->save();

	$c2g=new Comment2game();
	$c2g->comment_id=$c->id;
	$c2g->game_id=$id;
	//$c2g->save();
});

// PARTIE 6
$app->get('/api/platforms/{id}', function (Request $req,  Response $res, $args = []) {
    $id=$args['id'];
    $g = Platform::where('id', '=', $id )->get();
    $body = $res->getBody();
    $body->write("{$g}");
    return $res->withHeader('Content-Type', 'application/json')->withBody($body);
})->setName('Question6');

//PARTIE 7
$app->get("/api/games/{id}/characters",function (Request $req,  Response $res, $args = []) {
     $id=$args['id'];

    $body = $res->getBody();
    $body->write("{\n   \"characters\":[");

    foreach (Game::where('id', '=', $id)->get() as $game) {
        $characters = $game->characters;
        for ($i = 0; $i < count($characters); $i++) {
            $ch = $characters[$i];
            $tmp = $ch->id;
            $body->write("
                {\"character\" : {
                    \"id\": $ch->id,
                    \"name\": \"$ch->name\"
                    }," . "
                   \"links\":{
                    \"self\" : {\"href\" : \"" . ($GLOBALS["router"]->urlFor("characters", ["id" => $tmp])) . "\"}
                   }
                }");
            if($i < count($characters)-1)
                $body->write(",");
        }
    }
    $body->write("
    ]
}");

    return $res->withHeader('Content-Type', 'application/json')->withBody($body);
    
})->setName("Personnages");

$app->get("/api/characters/{id}", function (Request $req,  Response $res, $args = []){
    $id=$args['id'];
    $body = $res->getBody();
    foreach (Character::where('id', '=', $id)->get() as $c) {
        $body->write( "{\"character\": {\"id\": $c->id ,\"name\": \" $c->name\",\"deck\": \"$c->deck\"}}");
    }
    return $res->withHeader('Content-Type', 'application/json')->withBody($body);
})->setName("characters");



/**
$app->post("api/games/{id}/commentaire",function(Request $req, Response $res, $args=[]){
//$id=$args['id'];
//$jsonData = file_get_contents("php://input");
//$decode=json_decode($jsonData);
//$email=$decode->{'email'};
//$titre=$decode->{'titre'};
//$commentaire=$decode->{'commentaire'};
echo "lol";
});
*/
try{
	$app->run();
}catch (Throwable $e){
	echo "<pre>$e</pre>";
}
