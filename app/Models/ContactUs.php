<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ContactUs extends Model
{
    //设置表名
    const TABLE_NAME="contact_us";
    protected $table = self::TABLE_NAME;
    protected $primaryKey="cid";
    public $timestamps = false;
    protected $fillable = [
        'address', 'longitude','latitude','personal'
    ];

    //批量更新
    public function updateBatch($multipleData = [])
    {

        $tableName = DB::getTablePrefix() . $this->getTable(); // 表名
        $firstRow  = current($multipleData);

        $updateColumn = array_keys($firstRow);
        // 默认以key为条件更新，如果没有ID则以第一个字段为条件
        $referenceColumn = isset($firstRow['cid']) ? 'cid' : current($updateColumn);
        unset($updateColumn[0]);
        // 拼接sql语句
        $updateSql = "UPDATE " . $tableName . " SET ";
        $sets      = [];
        $bindings  = [];
        foreach ($updateColumn as $uColumn) {
            $setSql = "`" . $uColumn . "` = CASE ";
            foreach ($multipleData as $data) {
                $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                $bindings[] = $data[$referenceColumn];
                $bindings[] = $data[$uColumn];
            }
            $setSql .= "ELSE `" . $uColumn . "` END ";
            $sets[] = $setSql;
        }
        $updateSql .= implode(', ', $sets);
        $whereIn   = collect($multipleData)->pluck($referenceColumn)->values()->all();
        $bindings  = array_merge($bindings, $whereIn);
        $whereIn   = rtrim(str_repeat('?,', count($whereIn)), ',');
        $updateSql = rtrim($updateSql, ", ") . " WHERE `" . $referenceColumn . "` IN (" . $whereIn . ")";
        // 传入预处理sql语句和对应绑定数据
        return DB::update($updateSql, $bindings);

    }

    //通过id删除
    function  deleteByIdList($idlist){
        return self::destroy($idlist);
    }
}
