<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class Setting extends Model
{
    //设置表名
    const TABLE_NAME="settings";
    protected $table = self::TABLE_NAME;
    //protected $primaryKey="key";
    public $timestamps = false;

    //批量更新
    public function updateBatch($multipleData = [])
    {

            $tableName = DB::getTablePrefix() . $this->getTable(); // 表名
            $firstRow  = current($multipleData);

            $updateColumn = array_keys($firstRow);
            // 默认以key为条件更新，如果没有ID则以第一个字段为条件
            $referenceColumn = isset($firstRow['key']) ? 'key' : current($updateColumn);
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
}
