<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Models\Modules;

class AdvertisementController extends Controller {
    //列表
    function index() {
        $ad = Advertisement::leftJoin('modules','modules.identification','=','advertisement.display_module')
            ->orderBy('advertisement.create_at', 'desc')
            ->select([
                'advertisement.*',
                'modules.name as modules_name',
            ])
            ->paginate(__E('admin_page_count'));
        $displayPosition = self::getDisplayPosition();
        return view("admin/" . ADMIN_SKIN . "/advertisement/index", [
            "ad" => $ad,
            'displayPosition' => $displayPosition
        ]);
    }

    //获取显示位置
    public static function getDisplayPosition() {
        return [
            'top' => '上',
            'center' => '中',
            'bottom' => '下',
        ];
    }

    //添加
    function add() {
        $post = $this->request->all();
        if ($this->request->isMethod('post')) {
            //上传文件
            $images = UploadFile($this->request, "images", "advertisement/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
            if ($images) $post['images'] = $images;
            if (!strstr($post['url'], 'http')) $post['url'] = '#';
            $res = Advertisement::add($post);
            if ($res) {
                return ['status' => 200, 'msg' => '添加成功'];
            } else {
                return ['status' => 0, 'msg' => '添加失败'];
            }
        } else {
            $displayPosition = self::getDisplayPosition();
            $modules = Modules::where(['status' => 1, 'cloud_type' => 0])->get()->toarray();
            return view("admin/" . ADMIN_SKIN . "/advertisement/add", [
                'displayPosition' => $displayPosition,
                'modules' => $modules,
            ]);
        }
    }

    //编辑
    function edit() {
        $post = $this->request->all();
        if ($this->request->isMethod('post')) {
            $data = Advertisement::find($post['id']);
            if (!$data) return ['status' => 0, 'msg' => '数据不存在'];

            if ($_FILES['images']['size'] > 0) {
                //上传文件
                $images = UploadFile($this->request, "images", "advertisement/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                if ($images) $post['images'] = $images;
            }
            if (!strstr($post['url'], 'http')) $post['url'] = '#';
            $res = Advertisement::edit($post);
            if ($res) {
                return ['status' => 200, 'msg' => '编辑成功'];
            } else {
                return ['status' => 0, 'msg' => '编辑失败'];
            }


        } else {
            $data = Advertisement::find($post['id']);
            if (!$data) return back()->with("errormsg", "数据不存在！");
            $displayPosition = self::getDisplayPosition();
            $modules = Modules::where(['status' => 1, 'cloud_type' => 0])->get()->toarray();
            return view("admin/" . ADMIN_SKIN . "/advertisement/edit", [
                "data" => $data,
                'displayPosition' => $displayPosition,
                'modules' => $modules,
            ]);
        }
    }

    //删除
    function delete($id) {

        $data = Advertisement::find($id);

        if (!$data) return back()->with("errormsg", "数据不存在！");

        if (Advertisement::destroy($id)) {
            return back()->with("successmsg", "删除成功！");
        }
        return back()->with("errormsg", "删除失败！");

    }
}
