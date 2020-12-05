<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\VideoCategory;
use Illuminate\Http\Request;

class VideoController extends Controller {
    //列表
    function index(Request $request) {
        $params = $this->request->all();
        $params['search'] = isset($params['search']) ? $params['search'] : '';
        $video = Video::query()
            ->where('cid',$params['cid'])
            ->with(['cate'])
            ->orderByDesc('sort')
            ->orderByDesc('created_at');
        if (!empty($params['search'])) $video = $video->where('title', 'LIKE', '%' . $params['search'] . '%');
        return view("admin/" . ADMIN_SKIN . "/video/index", ["case" => $video->paginate(__E('admin_page_count')), 'params' => $params]);
    }

    //添加
    function add(Request $request) {
        set_time_limit(0);
        if ($request->isMethod('POST')) {
            $all = $request->all();
            if (!$all['title']) return back()->with("errormsg", "标题不能为空");
            //if (!$all['introduct']) return back()->with("errormsg", "简介不能为空");

            if ($all['type'] == 'local') {
                try {
                    $url = UploadFile($this->request, "file", "video/" . date("Y-m-d") . "/" . uniqid(), 'mp4,MP4', __E("upload_driver"));
                } catch (\Exception $e) {
                    return back()->with("errormsg", $e->getMessage());
                }
                $add['url'] = $url;
            } else {
                if (!$all['url']) return back()->with("errormsg", "视频路径不能为空");
                $add['url'] = $all['url'];
            }
            $add['cid'] = $all['cid'];
            $add['type'] = $all['type'];
            $add['title'] = $all['title'];
            $add['sort'] = intval($all['sort']);
            $add['introduct'] = $all['introduct'];
            $add['is_hot'] = $all['is_hot'];
            $add['is_rec'] = $all['is_rec'];
            $res = Video::query()->create($add);
            if ($res) {
                back()->with("successmsg", "添加成功");
                return redirect(url('admin/video?cid='.$all['cid']));
            } else {
                return back()->with("errormsg", '添加失败');
            }
        } else {
            $category = VideoCategory::query()->latest('id')->get();
            return view("admin/" . ADMIN_SKIN . "/video/add", [
                "category" => $category,
            ]);
        }
    }

    //编辑
    function edit(Request $request, $id) {
        set_time_limit(0);
        $data = Video::query()->find($id);
        if (!$data) return back()->with("errormsg", "数据不存在！");

        if ($request->isMethod('POST')) {
            $all = $request->all();
            if (!$all['title']) return back()->with("errormsg", "标题不能为空");
            //if (!$all['introduct']) return back()->with("errormsg", "简介不能为空");

            if ($all['type'] == 'local') {
                if ($_FILES['file']['size'] > 0) {
                    try {
                        $url = UploadFile($this->request, "file", "video/" . date("Y-m-d") . "/" . uniqid(), 'mp4,MP4', __E("upload_driver"));
                    } catch (\Exception $e) {
                        return back()->with("errormsg", $e->getMessage());
                    }
                    $add['url'] = $url;
                }
            } else {
                if (!$all['url']) return back()->with("errormsg", "视频路径不能为空");
                $add['url'] = $all['url'];
            }
            $add['cid'] = $all['cid'];
            $add['type'] = $all['type'];
            $add['title'] = $all['title'];
            $add['sort'] = intval($all['sort']);
            $add['introduct'] = $all['introduct'];
            $add['is_hot'] = $all['is_hot'];
            $add['is_rec'] = $all['is_rec'];
            $res = Video::query()->where('id', $id)->update($add);
            if ($res) {
                back()->with("successmsg", "编辑成功");
                return redirect(url('admin/video?cid='.$all['cid']));
            } else {
                return back()->with("errormsg", '编辑失败');
            }
        } else {
            $category = VideoCategory::query()->latest('id')->get();
            return view("admin/" . ADMIN_SKIN . "/video/edit", [
                "data" => $data,
                "category" => $category,
            ]);
        }

    }

    //删除
    function delete($id) {

        $data = Video::query()->find($id);

        if (!$data) {
            return back()->with("errormsg", "数据不存在！");
        }

        if (Video::destroy($id)) {
            return back()->with("successmsg", "删除成功！");
        }

        return back()->with("errormsg", "删除失败！");

    }


    //类别
    function category(Request $request) {

        $category = VideoCategory::query()->latest('id')->paginate(__E('admin_page_count'));

        return view("admin/" . ADMIN_SKIN . "/video/category", ["category" => $category]);
    }

    //类别
    function categoryAdd(Request $request) {
        $all = $this->request->all();
        if ($request->isMethod('POST')) {
            CheckArrIsEmpty($all, ["icon_css"]);

            //过滤参数
            if ($all["icon_type"] == "css") {
                $all["icon"] = $all["icon_css"];
            } else if ($all["icon_type"] == "img") {
                //文件上传
                if (isset($_FILES['icon_img'])) {
                    $pre_icon = UploadFile($this->request, "icon_img", "news/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                    if ($pre_icon) {
                        $all['icon'] = $pre_icon;
                    }
                }
            }
            $FaqCategory = new VideoCategory();
            $res = $FaqCategory->InsertArr($all);
            if ($res) {
                return ["status" => 200, "msg" => "success"];
            } else {
                return ["status" => 0, "msg" => "error"];
            }
        } else {
            return view("admin/" . ADMIN_SKIN . "/video/categoryAdd");
        }

    }

    //类别
    function categoryEdit(Request $request, $id = 0) {

        $all = $this->request->all();
        if ($request->isMethod('POST')) {
            CheckArrIsEmpty($all, ["icon_css"]);

            //过滤参数
            if ($all["icon_type"] == "css") {
                $all["icon"] = $all["icon_css"];
            } else if ($all["icon_type"] == "img") {
                //文件上传
                if (isset($_FILES['icon_img'])) {
                    $pre_icon = UploadFile($this->request, "icon_img", "news/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                    if ($pre_icon) {
                        $all['icon'] = $pre_icon;
                    }
                }
            }

            $FaqCategory = new VideoCategory();


            $res = $FaqCategory->UpdateArr($all);
            if ($res) {
                return ["status" => 200, "msg" => "success"];
            } else {
                return ["status" => 0, "msg" => "error"];
            }
        } else {
            $data = VideoCategory::find($id);
            if (!$data) return back()->with("errormsg", "数据不存在！");
            return view("admin/" . ADMIN_SKIN . "/video/categoryEdit", ["data" => $data]);
        }


    }

    //类别删除
    function categoryDelete($id) {

        $data = VideoCategory::find($id);

        if (!$data) {
            return back()->with("errormsg", "数据不存在！");
        }

        if (VideoCategory::destroy($id)) {
            return back()->with("successmsg", "删除成功！");
        }

        return back()->with("errormsg", "删除失败！");


    }
}
