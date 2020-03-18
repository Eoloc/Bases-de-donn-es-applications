<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;


class game extends Model{

    protected $table='game';
    protected $primaryKey='id';

    function games(string $name){
        return json_decode(game::where('name', 'like', "%$name%")->get());
    }

}