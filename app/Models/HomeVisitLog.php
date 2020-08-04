<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisitLog extends Model
{
    //设置表名
    const TABLE_NAME = "home_visit_logs";
    protected $table = self::TABLE_NAME;
    protected $guarded = [];

    public static function createLog($params = [])
    {
        $params['uid'] = empty($params['uid']) ? 0 : $params['uid'];
        $params['ip'] = get_ip();
        $http_referer = url()->previous();
        $this_url = request()->getUri();//url()->full()
        $params['current_url'] = empty($this_url) ? '' : $this_url;
        $params['http_referer'] = empty($http_referer) ? '' : $http_referer;
        $useragent = addslashes(strtolower($_SERVER['HTTP_USER_AGENT']));
        if(strpos($useragent, 'googlebot')!== false){$bot = 'Google';}
        elseif (strpos($useragent,'mediapartners-google') !== false){$bot = 'Google Adsense';}
        elseif (strpos($useragent,'baiduspider') !== false){$bot = 'Baidu';}
        elseif (strpos($useragent,'sogou spider') !== false){$bot = 'Sogou';}
        elseif (strpos($useragent,'sogou web') !== false){$bot = 'Sogou web';}
        elseif (strpos($useragent,'sosospider') !== false){$bot = 'SOSO';}
        elseif (strpos($useragent,'360spider') !== false){$bot = '360Spider';}
        elseif (strpos($useragent,'yahoo') !== false){$bot = 'Yahoo';}
        elseif (strpos($useragent,'msn') !== false){$bot = 'MSN';}
        elseif (strpos($useragent,'msnbot') !== false){$bot = 'msnbot';}
        elseif (strpos($useragent,'sohu') !== false){$bot = 'Sohu';}
        elseif (strpos($useragent,'yodaoBot') !== false){$bot = 'Yodao';}
        elseif (strpos($useragent,'twiceler') !== false){$bot = 'Twiceler';}
        elseif (strpos($useragent,'ia_archiver') !== false){$bot = 'Alexa_';}
        elseif (strpos($useragent,'iaarchiver') !== false){$bot = 'Alexa';}
        elseif (strpos($useragent,'slurp') !== false){$bot = '雅虎';}
        elseif (strpos($useragent,'bot') !== false){$bot = '其它蜘蛛';}
        if(isset($bot)){
            $params['spider'] = $bot;
        }
        $params['useragent'] = $useragent;
        self::create($params);
    }
}
