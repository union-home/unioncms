<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use App\Http\Controllers\Controller;

class BannerController extends Controller {
    //列表
    function index() {
        $ad = Banner::orderBy('create_at', 'desc')
            ->paginate(__E('admin_page_count'));
        return view("admin/" . ADMIN_SKIN . "/banner/index", ["ad" => $ad, 'params' => $params]);
    }

    //添加
    function add() {
        $post = $this->request->all();
        if ($this->request->isMethod('post')) {
            //上传文件
            $images = UploadFile($this->request, "images", "banner/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
            if ($images) $post['images'] = $images;
            if (!strstr($post['url'], 'http')) $post['url'] = '#';
            $res = Banner::add($post);
            if ($res) {
                return ['status' => 200, 'msg' => '添加成功'];
            } else {
                return ['status' => 0, 'msg' => '添加失败'];
            }
        } else {
            return view("admin/" . ADMIN_SKIN . "/banner/add", []);
        }
    }

    //编辑
    function edit() {
        $post = $this->request->all();
        if ($this->request->isMethod('post')) {
            $data = Banner::find($post['id']);
            if (!$data) return ['status' => 0, 'msg' => '数据不存在'];

            if ($_FILES['images']['size'] > 0) {
                //上传文件
                $images = UploadFile($this->request, "images", "banner/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                if ($images) $post['images'] = $images;
            }
            if (!strstr($post['url'], 'http')) $post['url'] = '#';
            $res = Banner::edit($post);
            if ($res) {
                return ['status' => 200, 'msg' => '编辑成功'];
            } else {
                return ['status' => 0, 'msg' => '编辑失败'];
            }


        } else {
            $data = Banner::find($post['id']);
            if (!$data) return back()->with("errormsg", "数据不存在！");
            return view("admin/" . ADMIN_SKIN . "/banner/edit", ["data" => $data]);
        }
    }

    //删除
    function delete($id) {

        $data = Banner::find($id);

        if (!$data) return back()->with("errormsg", "数据不存在！");

        if (Banner::destroy($id)) {
            return back()->with("successmsg", "删除成功！");
        }
        return back()->with("errormsg", "删除失败！");

    }
}
