<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;

class genre extends Model{
    protected $table='genre';
    protected $primaryKey='id';
public $timestamps = false;

public function modifierJeu($idGame,$idGenre){
$game=bdd\models\Game::where('id','=',$idGame)->first();
$g2g=new Game2genre();
$g2g->game_id=$game->id;
$g2g->genre_id=$idGenre;
$g2g->save();
}    

}
