<?php
/**
 * 数据查询
 * @param $model
 * @param array $where
 * @param int $limit
 * @param array $orderby
 * @param int $start_paginate 是否开启分页：0.否；1.是
 * @return mixed
 */
function get_table_select($table, $where = [], $limit = 10, $orderby = [], $start_paginate = 0)
{
    $table = \Illuminate\Support\Facades\DB::table($table);
    if ($where) $table = $table->where($where);
    if ($orderby) $table = $table->orderBy($orderby);
    if (intval($limit) == 1) return $table->first();//单条数据查询
    else{
        if ($start_paginate == 1) return $table->paginate($limit);//分页
        else return $table->limit($limit)->get();
    }
}

/**
 * 获取单表指定字段的值
 */
function get_filed_value($table, $filed, $where = [], $orderby = [])
{
	$table = \Illuminate\Support\Facades\DB::table($table);
	if ($where) $table = $table->where($where);
    if ($orderby) $table = $table->orderBy($orderby);
	return $table->value($filed);
}