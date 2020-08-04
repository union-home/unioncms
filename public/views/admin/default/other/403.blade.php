@include("admin.".ADMIN_SKIN.".header")
<body class="bg-light">

<div class="misc-wrapper">
    <div class="misc-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6">
                    <div class="misc-box text-center">
                        <h1 class="text-muted fs-large">403</h1>
                        <h4 class="font-300">{!! $content !!}}</h4>
                        <a href="{{url('/')}}" class="btn btn-lg btn-primary btn-rounded box-shadow mt-10">Back to home</a>
                    </div>
                    <div class="text-center misc-footer">
                        <p>Copyright &copy;  2018 UnionCMS系统</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Common Plugins -->
@include('admin/'.ADMIN_SKIN.'/js',['load'=> ["custom"]])

</body>
</html>
