<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    //国家列表
    function country(){

        $country = Country::orderBy('c_country_code','asc')->paginate(cacheGlobalSettingsByKey('admin_page_count'));


        return view("admin/".ADMIN_SKIN."/country/country",["country"=>$country]);
    }

    //地区列表
    function region($country_code,$level=1){

        $region = Region::where("country_code","=",$country_code)
                    ->where("level","=",$level)
                    ->orderBy('region_code','asc')
                    ->paginate(cacheGlobalSettingsByKey('admin_page_count'));

        return view("admin/".ADMIN_SKIN."/country/region",["region"=>$region]);
    }
}
