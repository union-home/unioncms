var common={
    init:function(){
       this.bindEvent();
    },
    bindEvent:function(){
        // 导航菜单
        var _this=this;
        if($(document).width()>992){
            _this.showMenu();
        }
        $(window).resize(function(){
            if($(document).width()>992){
                _this.showMenu();
            }else{
                $(".submenu-group").unbind()
            }
        });

        $(".submenu-item~i").click(function(e){
            e.stopPropagation();
           $(this).parent().siblings().toggleClass("isActive")
        });

        $(document).on("click",function(){
            $(".navbar-collapse").removeClass("show")
        });


        // 左侧分享
        $(".customer-item").on("mouseenter",function(){
            $(".customer-item").removeClass("active");
        });

        // 手机下切换
        $(".customer-item").on("click",function(){
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
        });

        // 返回顶部
        $(".back-top").click(function(){
            $('html , body').animate({scrollTop: 0},'slow');
        });

        // $(document).on("mouseleave",".customer",function(){
        //     $(".customer-item").removeClass("active");
        // });

        // 留言板
        $(".message-submit").click(function(){
            var message=$(".message-content>textarea");
            var info=$(".message-group");
            if(!message.val()){
                return ;
            }
            if($(".nomessage").length){
                info.html(
                    '<div class="p-3">'+ message.val()+'</div>'
                )
            }else{
                info.html(info.html()+'<div class="p-3">'+ message.val()+'</div>')
            }
        });

        // 模板搜索
        $(".sort-type").click(function(){
            $(".sort-type").removeClass("active");
            $(this).addClass("active")
        });
        $('.sort-menu').click(function(){
            $(".sort-menu-item").toggleClass("active")
        });

        $(".case-item").click(function(){
            var info=$(".case-info>li");
            if($(window).width()>992){
                $(".case-item").removeClass("active");
                $(this).addClass("active");
                switch($.trim($(this).children(".case-text").text())){
                    case "应用介绍":
                        info.removeClass("active");
                        $(".introduce").addClass("active");
                        break;
                    case "更新日志":
                        info.removeClass("active");
                        $(".update").addClass("active");
                        break;
                    case "资料下载（1）":
                        info.removeClass("active");
                        $(".download").addClass("active");
                        break;
                    case "用户评论":
                        info.removeClass("active");
                        $(".comment").addClass("active");
                        break;
                }
                return ;
            }
            // 小屏下
            $(this).children("span").toggleClass("active");
            $(this).children("div").toggleClass("active");
            $(this).children(".case-text").children(".expand").toggleClass("active")
        })
    },
    showMenu:function(){
        $(".submenu-group").mousemove(function(){
            $(".submenu-group").removeClass("isActive");
            $(this).addClass("isActive")
        });
        $(document).scroll(function(){
            $(".submenu-group").removeClass("isActive")
        });
        $(document).click(function(){
            $(".submenu-group").removeClass("isActive")
        });
    }
};
$(function(){
   common.init();
});
