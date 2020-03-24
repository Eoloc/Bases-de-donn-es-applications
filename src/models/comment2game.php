<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;

class comment2game extends Model{
    protected $table='comment2game';
    protected $primaryKey='id';
    public $timestamps = false;
    protected $fillable = [ 'omment_id', 'game_id'
    ];



}
