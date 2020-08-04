<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TemplateMessage extends Model
{
    const TABLE_NAME = 'template_message',
        TEMPLATE_TYPE = [
            0 => '邮件',
            1 => '短信',
        ];
    protected $table = self::TABLE_NAME;
    public $timestamps = true;

    public static function getAdminList()
    {
        $all_template = self::get()->toArray();
        $return_template = [];
        foreach($all_template as $v)
        {
            $return_template[$v['template_key']] = $v;
        }
        return $return_template;
    }

    //批量更新
    public static function updateBatch($multipleData = [])
    {
        $tableName = DB::getTablePrefix() . self::TABLE_NAME; // 表名
        $firstRow  = current($multipleData);

        $updateColumn = array_keys($firstRow);
        // 默认以key为条件更新，如果没有ID则以第一个字段为条件
        $referenceColumn = isset($firstRow['key']) ? 'key' : current($updateColumn);
        unset($updateColumn[0]);
        // 拼接sql语句
        $updateSql = "UPDATE " . $tableName . " SET updated_at = ?, ";
        $sets      = [];
        $bindings  = [date('Y-m-d H:i:s')];
        foreach ($updateColumn as $uColumn) {
            $setSql = "`" . $uColumn . "` = (CASE ";
            foreach ($multipleData as $data) {
                $setSql .= "WHEN `" . $referenceColumn . "` = ? THEN ? ";
                $bindings[] = $data[$referenceColumn];
                $bindings[] = $data[$uColumn];
            }
            $setSql .= "ELSE `" . $uColumn . "` END )";
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

    /**
     * 获取模板消息内容
     * @param $key
     * @param string $array 也可以是数组
     * @param string $_code 对应数组
     * @return array
     */
    public static function getTemplateMessage($key, $array = '', $_code = '{$code}')
    {
        $template = self::where('template_key', $key)->first();
        if(empty($template)) return ['msg' => '模板消息不存在', 'status' => 0];
        // {' . self::TEMPLATE_TYPE[$template["template_type"]] . '}
        if($template['is_start'] != 1) return ['msg' => '模板消息{' . $template["template_name"] . '}尚未开启', 'status' => 0];
        return ['data' => str_replace($_code, $array, $template['template_value']), 'status' => 1];
    }
}
