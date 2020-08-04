<!-- Scroll to top -->
<a href="#" class="scroll-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{HOME_ASSET}}assets/js/jquery.min.js"></script>
<!-- Popper JS -->
<script src="{{HOME_ASSET}}assets/js/popper.min.js"></script>
<!-- Bootsrap JS -->
<script src="{{HOME_ASSET}}assets/assets/bootstrap/js/bootstrap.min.js"></script>
<!-- Select2 JS -->
<script src="{{HOME_ASSET}}assets/assets/select2/js/select2.min.js"></script>
<!-- Owl Carousal JS -->
<script src="{{HOME_ASSET}}assets/assets/owl-carousel/js/owl.carousel.min.js"></script>
<!-- Match Height JS -->
<script src="{{HOME_ASSET}}assets/assets/matchHeight/js/matchHeight-min.js"></script>
<!-- Vide JS -->
<script src="{{HOME_ASSET}}assets/assets/vide/js/vide.min.js"></script>
<!-- Video Popup JS -->
<script src="{{HOME_ASSET}}assets/assets/magnific-popup/js/magnific-popup.min.js"></script>
<script type="text/javascript" src="{{HOME_ASSET}}assets/other/jqueryToast/js/toast.script.js"></script>
<!-- Custom JS -->
<script src="{{HOME_ASSET}}assets/js/custom.js"></script>
</body>
</html>
<script>
    $(function () {

        $(".custom_select").change(function () {
            location.href = "{{url('language')}}"+"/"+$(this).val();
        })

        var toastMsg;
        var toastType;

        if(toastMsg){
            $.Toast("温馨提示!", toastMsg, toastType, {
                // append to body
                appendTo: "body",
                // is stackable?
                stack: true,
                // 'toast-top-left'
                // 'toast-top-right'
                // 'toast-top-center'
                // 'toast-bottom-left'
                // 'toast-bottom-right'
                // 'toast-bottom-center'
                position_class: "toast-bottom-right",
                // true = snackbar
                fullscreen: false,
                // width
                width: 250,
                // space between toasts
                spacing: 20,
                // in milliseconds
                timeout: 2000,
                // has close button
                has_close_btn: false,
                // has icon
                has_icon: false,
                // is sticky
                sticky: false,
                // border radius in pixels
                border_radius: 6,
                // has progress bar
                has_progress: true,
                // RTL support
                rtl: false
            });
        }
    })
</script>