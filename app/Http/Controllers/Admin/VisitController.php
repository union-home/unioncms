<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeVisitLog;

class VisitController extends Controller
{
    //单页列表
    function index(){
        $month_list = [];
        for ($i=1; $i <= 12; $i++) $month_list[] = $i;

        return view("admin/".ADMIN_SKIN."/visit/index",[
            'month_list' => $month_list,
            'year_list' => range(date("Y"), date("Y", strtotime("now - 10 years"))),
        ]);
    }

    //统计访问数据
    function ajaxStatistics()
    {
        $params = $this->request->all();
        $params['show_type'] = isset($params['show_type']) ? $params['show_type'] : 0;
        $params['selected_year'] = isset($params['selected_year']) ? $params['selected_year'] : date('Y');
        $params['selected_month'] = isset($params['selected_month']) ? $params['selected_month'] : date('m');
        $month_list = $statistic = [];
        switch (intval($params['show_type'])) {
            case 1: //按月统计
                for ($i=1; $i <= 12; $i++) $month_list[] = $i;
                $logs = HomeVisitLog::where('created_at', '>=', (string)$params['selected_year'])
                    ->where('created_at', '<=', (string)($params['selected_year'] + 1))
                    ->select('created_at')
                    ->get()
                    ->toArray();
                if (!empty($logs)) {
                    array_walk($logs, function($value, $key) use ($params, &$month_list, &$statistic){
                        foreach ($month_list as $k => $val) {
                            $val_text = $val . '月';
                            $start_time = $params['selected_year'] . '-' . set_month_format($val);
                            $end_time = date('Y-m', strtotime('+1 month', strtotime($start_time)));
                            if (empty($statistic[$val_text])) $statistic[$val . '月'] = 0;
                            if ($value['created_at'] >= $start_time && $value['created_at'] <= $end_time) $statistic[$val_text] += 1;
                        }
                    });
                }else{
                    foreach ($month_list as $key => $value) $statistic[$value . '月'] = 0;
                }
                break;
            default: //按天统计
                $day_list = get_month_days(strtotime($params['selected_year'] . '-' . $params['selected_month']));
                $logs = HomeVisitLog::where('created_at', '>=', $params['selected_year'] . '-' . set_month_format($params['selected_month']))
                    ->where('created_at', '<=', $params['selected_year'] . '-' . set_month_format(($params['selected_month'] + 1)))
                    ->select('created_at')
                    ->get()
                    ->toArray();
                if (!empty($logs)) {
                    array_walk($logs, function($value, $key) use (&$day_list, &$statistic){
                        foreach ($day_list as $k => $val) {
                            $start_time = $val . ' 00:00:00';
                            $end_time = $val . ' 23:59:59';
                            if (empty($statistic[$val])) $statistic[$val] = 0;
                            if ($value['created_at'] >= $start_time && $value['created_at'] <= $end_time) $statistic[$val] += 1;
                        }
                    });
                }else{
                    foreach ($day_list as $key => $value) $statistic[$value] = 0;
                }
                break;
        }
        $return = return_api_format([
            'data' => [
                '_value' => array_values($statistic),
                '_list' => array_keys($statistic)
            ],
            'status' => 200
        ]);
        unset($params, $logs, $day_list, $statistic);
        return $return;
    }
}
