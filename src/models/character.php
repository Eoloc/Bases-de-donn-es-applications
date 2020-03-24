<?php

namespace bdd\models;


class character extends \Illuminate\Database\Eloquent\Model{

    protected $table='character';
    protected $primaryKey='id';
    protected $fillable = [ 'name', 'real_name', 'last_name','alias',
        'deck', 'description',
        'birthday', 'gender', 'first_appeared_in_game_id'
    ];

    public function first_appeared_in_game() {
        return $this->belongsTo('\bdd\models\game', 'first_appeared_in_game_id');
    }

    public function games() {
        return $this->belongsToMany('\bdd\models\game', 'game2character', 'character_id', 'game_id');
    }

    public function friends() {
        return $this->belongsToMany('\bdd\models\character', 'friends', 'char1_id', 'char2_id');
    }

    public function enemies() {
        return $this->belongsToMany('\bdd\models\character', 'enemies', 'char1_id', 'char2_id');
    }
}