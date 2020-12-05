<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model {
    //设置表名
    const TABLE_NAME = "video";
    const PK = "id";
    public $table = self::TABLE_NAME;
    public $primaryKey = self::PK;
    public $timestamps = true;

    public $fillable = ['cid', 'type', 'title', 'url', 'introduct', 'created_at', 'updated_at', 'is_hot', 'is_rec', 'sort'];

    const type = [
        'local' => '本地上传',
        'remote_video_path' => '远程视频路径',
        'tengxun' => '腾讯',
        'youku' => '优酷',
    ];

    public function cate() {
        return $this->hasOne(VideoCategory::class, 'id', 'cid');
    }
}
