<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;


class company extends Model{

    protected $table='company';
    protected $primaryKey='id';

    public function developpedBy() {
        return $this->belongsToMany('\bdd\models\game', 'game_developers', 'game_id', 'comp_id');
    }
}