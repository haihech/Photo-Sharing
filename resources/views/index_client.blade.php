<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Sua</title>
        <!-- Bootstrap -->
        <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('css/rollup-fac65cc2.css')}}" rel="stylesheet">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
        <link href="{{asset('font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet">
        <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
        <script src="{{asset('js/jquery-ui.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        @yield('css')
   
    </head>
    <body>
        <header>
        <nav class="navbar navbar-default bg-header" style="background-color: rgba(21,21,23,.95);">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img alt="Brand" src="{{asset('images/brand.png')}}"></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav menu">
                  <li><a href="#" style="color: #fff; font-size: 16px;">Hot</a></li>
                  <li><a href="#" style="color: #fff; font-size: 16px;">Mới</a></li>
                  <li><a href="#" style="color: #fff; font-size: 16px;">Ảnh hài</a></li>
                  <li><a href="#" style="color: #fff; font-size: 16px;">Ảnh đẹp nhất 2016</a></li>
              </ul>

              <form action="{{ url('search') }}" method="get" class="navbar-form navbar-left" >
                  <div class="input-group">
                      <div class="ui-widget">
                        <input type="text" id="search" name="search" class="form-control" placeholder="Ảnh...">
                        <div class="dropdown-menu" id="productList" role="menu"></div>
                      </div>
                            
                  </div>
                  <div class="input-group">
                    <input type="submit" name="search-product" value="Tìm kiếm" class="btn btn-primary">
                  </div>
              </form>
              <ul class="nav navbar-nav navbar-right menu">
                  
                  
                  <li><a href="#"><i class="upload-icon" title="Tải lên" aria-hidden="true">Tải lên</i></a></li>
                <li><a data-track="gnSignin" class="gn-title" href="#" style="color: #fff;">Đăng nhập</a></li>
                <li class="gn-signup" role="menuitem" aria-label="Đăng ký">
                    <a data-track="gnSignupClick" class="gn-title btn btn-success no-outline" href="#" style="color: #fff;">Đăng ký</a>
                </li>
                
              </ul>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </header>
     
    @yield('content')

    </body>
  <script>
    
  </script>

</html>
