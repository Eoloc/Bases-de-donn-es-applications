<?php

namespace bdd\models;
use Illuminate\Database\Eloquent\Model;


class company extends Model{

    protected $table='company';
    protected $primaryKey='id';

    static function pays(string $name){
        return json_decode(company::where('location_country', 'like', "$name")->get());
    }

}