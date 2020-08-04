@include("admin.".ADMIN_SKIN.".header")

<body class="horizontal">

<!-- ============================================================== -->
<!-- 						Topbar Start 							-->
<!-- ============================================================== -->
@include("admin.".ADMIN_SKIN.".topbar")
<!-- ============================================================== -->
<!--                        Topbar End                              -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- 						Navigation Start 						-->
<!-- ============================================================== -->

@include("admin.".ADMIN_SKIN.".nav")

<!-- ============================================================== -->
<!-- 						Navigation End	 						-->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- 						Content Start	 						-->
<!-- ============================================================== -->
<style type="text/css">
    #echart-main{min-height:30rem;}
</style>

<div class="row page-header">
    <div class="col-lg-6 align-self-center ">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">{{getTranslateByKey("common_home_page")}}</a></li>
            <li class="breadcrumb-item"><a href="#">其他相关</a></li>
            <li class="breadcrumb-item active">访问统计</li>
        </ol>
    </div>
</div>

<section class="main-content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <div>按日统计：<input type="radio" name="show_type" value="0" checked="" /></div>
                        <div>按月统计：<input type="radio" name="show_type" value="1" /></div>
                        年份：<select name="selected_year">
                            @if($year_list)
                                @foreach($year_list as $year)
                                    <option value="{{$year}}"> {{$year}} </option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        月份：<select name="selected_month">
                            @if($month_list)
                                @foreach($month_list as $month)
                                    <option value="{{$month}}" @if($month == date('m')) selected @endif > {{$month}} </option>
                                @endforeach
                            @endif
                        </select>
                        <br>
                        <div onclick="ajaxStatistics()"> 筛选浏览 </div>
                    </div>
                    <div class="col-md-12" id="echart-main"></div>
                </div>
            </div>
        </div>
    </div>

    @include('admin/'.ADMIN_SKIN.'/footer')
</section>
<!-- ============================================================== -->
<!-- 						Content End		 						-->
<!-- ============================================================== -->


<!-- Common Plugins -->
@include('admin/'.ADMIN_SKIN.'/js',['load'=> ["custom"]])

<script type="text/javascript" src="{{ADMIN_ASSET}}assets/other/echarts/js/echarts.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('echart-main'));

    ajaxStatistics();
    function ajaxStatistics(show_type, selected_year, selected_month) {
        show_type = show_type == undefined ? $('input[type=radio]:checked').val() : show_type;
        selected_year = selected_year == undefined ? $('select[name=selected_year]').val() : selected_year;
        selected_month = selected_month == undefined ? $('select[name=selected_month]').val() : selected_month;
        $.ajax({
            headers: {
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            "url" : "{{url('admin/visit/ajaxStatistics')}}",
            "method":"POST",
            "data": {
                show_type : show_type,
                selected_year : selected_year,
                selected_month : selected_month,
            },
            "dataType":'json',
            "success":function (res) {
                myChartOption(res.data);
            },
            "error":function (res) {
                console.log(res);
            }
        });
    }

    function myChartOption(res)
    {
        // 指定图表的配置项和数据
        var option = {
            title: {
                text: '访问统计图'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data:['访问量']
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : res._list
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'访问量',
                    type:'line',
                    stack: '总量',
                    areaStyle: {},
                    data:res._value,
                    smooth: true
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
    }
</script>
</body>
</html>