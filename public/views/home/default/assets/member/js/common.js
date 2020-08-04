common={
    init:function(){
       this.bindEvent();
    },
    bindEvent:function(){
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

        $(document).click(function(){
            $(".navbar-collapse").removeClass("show")
        });


        $(".customer-item").mouseenter(function(){
            $(this).addClass("active");
        }).mouseleave(function(){
            $(this).removeClass("active")
        });
        // 手机下切换
        $(".customer-item").click(function(){
            $(this).siblings().removeClass("active");
            $(this).addClass("active");
        });
        $(".back-top").click(function(){
            document.documentElement.scrollTop=0;
        });

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
