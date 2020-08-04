<div class="main-horizontal-nav">
    <nav>
        <!-- Menu Toggle btn-->
        <div class="menu-toggle">
            <h3>菜单导航</h3>
            <button type="button" id="menu-btn">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
            {{getAdminMenus($menus)}}
            <li><a href="{{url("admin/feature")}}"><i class="fa fa-puzzle-piece"></i> 功能模块</a></li>
            @if(cacheGlobalSettingsByKey('Useofcloud') =='true')
                <li>
                    <a href="{{url('admin/cloud')}}"><i class="fa fa-cloud"></i> 云应用</a>
                </li>
            @endif
        </ul>
    </nav>
</div>