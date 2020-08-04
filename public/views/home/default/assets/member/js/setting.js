setting={
    init:function(){
        this.bindEvent()
    },
    bindEvent:function(){
        $(".radion-icon").click(function(){
            $(".radion-icon").removeClass("active");
            $(this).addClass("active");
        });
        $(".setting-group>ul>li").click(function(){
            $(".setting-group>ul>li").removeClass("active");
            $(this).addClass("active");
            var settingType=$(".setting>ul>li");
            switch($(this).text()){
                case "用户资料":
                    settingType.removeClass("active");
                    $('.userinfo').addClass("active");
                    break;
                case "帐号安全":
                    settingType.removeClass("active");
                    $('.safety').addClass("active");
            }
        })
    }
};
$(function(){
   setting.init()
});