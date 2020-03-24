<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;


class user extends Model{

    protected $table='user';
    protected $primaryKey='email';
    public $timestamps = false;

}