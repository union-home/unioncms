<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    //设置表名
    const TABLE_NAME="currency";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="id";
    public $timestamps = false;

    private $field;

    function InsertArr($arr){

        if (!is_array($arr)){
            return ;
        }
        $this->name = $arr["name"];
        $this->code = $arr["code"];
        $this->symbol = $arr["symbol"];
        $this->is_fix = 0;
        $this->rate = $arr["rate"];
        $this->position = $arr["position"];
        $this->create_at = date("Y-m-d H:i:s");
        $this->update_at = date("Y-m-d H:i:s");

        self::save();

    }

    function UpdateArr($arr){
        if (!is_array($arr)){
            return ;
        }

        $curren = $this->find($arr["id"]);

        $curren->name = $arr["name"];
        $curren->code = $arr["code"];
        $curren->symbol = $arr["symbol"];
        $curren->rate = $arr["rate"];
        $curren->position = $arr["position"];
        $curren->update_at = date("Y-m-d H:i:s");

        $curren->save();
    }

    static function getAll(){

        $data = self::all();

        return  $data?$data->toArray():[];
    }










}
