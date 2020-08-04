@include("home.".HOME_SKIN.".header")

@include("home.".HOME_SKIN.".nav")

<main class="template">
    <div class="banner"></div>
    <div class="map my-md-4 my-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row py-3">
                        <div class="col-12 text-center">
                            <h4>联系我们</h4>
                            <p class="tc-gray-99 mb-0">CONTACT US</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <div id="buiduMap" class="buiduMap"></div>
    </div>

    <div class="news my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 lh-30 tc-gray-99">

                    @foreach($contact_infos as $contact_info)

                        <div class="">
                            <h5>{{$contact_info->company_name}}</h5>
                            <p>
                                专注品牌事业十余年，是一家具有创新动力、全方位跨平台的品牌咨询与设计整合服务公司。公司业务涉及大数据、智能多媒体、物联网。
                            </p>
                        </div>
                        <div class="mt-md-5 mt-3">
                            <ul class="list-unstyled">
                                @foreach(json_decode($contact_info->personal) as $val)
                                    <li>{{$val->name}}：{{$val->contact}}</li>
                                @endforeach
                                <li>联系地址：{{$contact_info->address}}</li>
                            </ul>
                        </div>
                    @endforeach

                </div>
                <div class="col-md-6 col-12">
                    <img class="w-100" src="{{HOME_ASSET}}assets/img/sidebar-img.png" alt="">
                </div>
            </div>
        </div>
    </div>

</main>

@include("home.".HOME_SKIN.".footer")

<script type="text/javascript" src="http://api.map.baidu.com/api?v=3.0&ak=LyrHg3By3UXzo1h4OrxI5EdXU7L0X3Gv"></script>
<script>
    var map = new BMap.Map("buiduMap");          // 创建地图实例
    var point = new BMap.Point(114.257859,22.727858);  // 创建点坐标
    map.centerAndZoom(point, 15);
    map.enableScrollWheelZoom(true);
    var marker = new BMap.Marker(point);        // 创建标注
    map.addOverlay(marker);
</script>