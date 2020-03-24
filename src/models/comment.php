<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;


class comment extends Model{

    protected $table='comment';
    protected $primaryKey='id';
    public $timestamps = true;

}