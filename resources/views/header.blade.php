<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>Photo Sharing</title>
  <!-- Bootstrap -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/login.css')}}" rel="stylesheet">
  <link href="{{asset('css/jquery-ui.css')}}" rel="stylesheet">
  <link href="{{asset('font-awesome-4.6.3/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('font-awesome-4.6.3/css/font-awesome.css')}}" rel="stylesheet">
  <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
  <script src="{{asset('js/jquery-ui.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>

  <script src="{{asset('js/scripts.min.js')}}"></script>
  @yield('css')

</head>
<body>

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
        <a class="navbar-brand" href="{{ route('home') }}" style="margin-left: 5px;padding: 10px"><img  alt="Brand" src="{{asset('images/home_icon.png')}}"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav menu">
          {{-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color: #fff; font-size: 16px;">Bạn<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="#" class="btn" role="button">Kho ảnh</a></li>
              <li><a href="#" class="btn" role="button">Album</a></li>
              <li><a href="#" class="btn" role="button">Mục yêu thích</a></li>
            </ul>
          </li> --}}
         
          <li ><a href="{{ route('home') }}" style="color: #F4F4F4; font-size: 16px;">Mới</a></li>
          <li><a href="{{ route('hot') }}" style="color: #F4F4F4; font-size: 16px;">Hot</a></li>
          <li><a href="{{ route('binhchon') }}" style="color: #F4F4F4; font-size: 16px;">Bình chọn</a></li>
          <li><a href="{{ route('haihuoc')}}" style="color: #F4F4F4; font-size: 16px;">Ảnh hài</a></li>
          <li><a href="{{ route('girl')}}" style="color: #F4F4F4; font-size: 16px;">Girl xinh</a></li>
          <li><a href="{{ route('khac')}}" style="color: #F4F4F4; font-size: 16px;">Khác</a></li>
         {{--  <li><a href="#" style="color: #fff; font-size: 16px;">Ảnh đẹp nhất 2016 <span class="label-beta">Mới</span></a></li> --}}
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


          <li><a href="#" data-toggle="modal" data-target="#modalUploadImg"><i class="upload-icon" title="Tải lên" aria-hidden="true">Tải lên</i></a></li>

          <!-- Modal -->
          <div class="modal fade" id="modalUploadImg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
              @if(Auth::check())
              <iframe style="display: none;" name="resultPost" id="resultPost"></iframe>
               <form action="{{ route('post') }}" enctype="multipart/form-data" method="post" id="formPostImg">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h2 class="modal-title" id="myModalLabel"><b>Đăng ảnh</b></h2>
                  {{-- <p class="lead ng-scope">Chọn file từ máy tính của bạn, chúng tôi hỗ trợ upload Ảnh lên hệ thống.</p> --}}
                </div>
                <div class="modal-body">
                  
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="file-field" style="width: 500px; margin-left: 35px;">
                    <input type="file" required='required' name="img" accept="image/*" class="file text ng-scope">
                  </div>
                  <br>
                  <div class="field title"  style="width: 500px; margin-left: 35px;">
                    <div><label>Tiêu Đề</label>
                    </div>
                    
                    <textarea required='required' style="width: 500px; height: 80px; line-height: 1.6em;" rows="4" cols="50" maxlength="100" name="title" placeholder="Tối đa 100 ký tự..." ></textarea>
                    
                  </div>
                   <div style="width: 500px; margin-left: 35px;">
                     <label>Thể Loại</label>
                     <select style="width: 500px" class="selectpicker form-control" id="typeImg" name="type"></select>
                   </div>
                   <script>
                     $.ajax({
                        url:'{{ url('getType') }}',
                        method:'GET',
                        success:function(data){
                          $('#typeImg').html(data);
                        }
                     });
                   </script>
                <hr>
                <div>
                  <center><a role="button" onmouseup="postImg()" class=" btn btn-primary"> Đăng lên</a>
                    </center>

                    <br/><br/>
                  </div>
                </div>
                </form>
                @else
                <div class="modal-header" style="text-align: center;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h2>Bạn phải đăng nhập trước khi đăng ảnh!</h2>
                    <li style="margin-left: 20px" class="gn-signup" role="menuitem" aria-label="Đăng ký">
                    <a data-track="gnSignupClick" class="gn-title btn btn-success no-outline" href="#" style="color: #fff;" data-toggle="modal" data-target="#modalLogin" >Đăng Nhập</a>
                  </li>
                </div>
                @endif
              </div>
            </div>
          </div>

          <li role="menuitem" >
            <div class="view notifications-menu-view"><a class="gn-title c-notifications-menu no-outline" tabindex="0" aria-haspopup="true" aria-expanded="false" aria-label="Thông báo">
              <span class="c-notification-icon" aria-hidden="true" aria-expanded="true">
                <span class="c-notification-unseencount hidden"></span>
              </span>
            </a></div>

          </li>
{{-- 
          <li style="margin-left: 20px" class="gn-signup" role="menuitem" aria-label="Đăng ký">
            <a data-track="gnSignupClick" class="gn-title btn btn-success no-outline" href="#" style="color: #fff;">Đăng xuất</a>
          </li> --}}

          @if(!Auth::check())
          <li style="margin-left: 20px" class="gn-signup" role="menuitem" aria-label="Đăng ký">
            <a data-track="gnSignupClick" class="gn-title btn btn-success no-outline" href="#" style="color: #fff;" data-toggle="modal" data-target="#modalLogin" >Đăng Nhập</a>
          </li>
          @else
          <li style="margin-top: -3px"><a href="#" data-toggle="collapse" data-target="#InfoUser"><img style="height:30px;vertical-align: middle; " src="{{ asset('images').'/'.Auth::user()->avatar }}" alt=""></a>
          <!-- Info User -->
           <div class="collapse" id="InfoUser">
              <ul>
                <li><a href="{{ route('u') }}">Trang cá nhân</a></li>
                <li><a href="{{ route('profile') }}">Tài khoản</a></li>
                <li><a href="{{ route('logout') }}">Đăng Xuất</a></li>
              </ul>
          </div>
          </li>
          
          @endif
          <!-- Modal -->
          <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h2 class="modal-title" id="myModalLabel"><b>Đăng Nhập</b></h2>
                  <p class="ng-scope" style="margin-top: 20px">Đăng nhập ngay không cần đăng ký</p>
                  <p  style="margin-top: 20px;text-align: center;color:#828282"> Bấm nút Đăng nhập để tiếp tục. <br>
                  <fb:login-button style="margin-top: 10px;" scope="public_profile,email" data-size="xlarge" onlogin="checkLoginState();">
                   </fb:login-button>
                   <div id="status"></div>
                  </p>
                  
                </div>
                <div class="modal-body">

                 </div>
              
              </div>
            </div>
          </div>
        </ul>
      </div>
    </div>
  </nav>
   <div class="modal fade" id="showResultPost" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="text-align: center;padding: 100px ">
         
            @if(session()->has('post'))
              @if(session()->get('post')=='success')
                 <h3>Đăng bài thành công!</h3>
              @else
                <h3>Đã xảy ra lỗi khi đăng bài!</h3>
              @endif
            @endif
        </div>
      </div>
    </div>
  @if(session()->has('post'))
    <script>
      $('#showResultPost').modal('show');
    </script>
  @endif
  @yield('content')

</body>
<script>
  function postImg(){
     $("#formPostImg").submit();
      
  }
</script>
<script>
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
       testAPI();  
    } else if (response.status === 'not_authorized') {
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into Facebook.';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1657324371231307',
      cookie     : true,  // enable cookies to allow the server to access 
                          // the session
      xfbml      : true,  // parse social plugins on this page
      version    : 'v2.8' // use graph api version 2.8
    });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
    FB.api('/me?fields=id,name,email', function(response) {
      checklogin(response);
    });
  }
  function checklogin(response){

     url="{{URL::to('/loginFb')}}"+"/"+response.id+"/"+response.name+"/"+response.email;
     $.ajax({
          url:url,
          method: "GET",
          success:function(data){
            if(data=='ok') {
              location.reload();
            }
          }
        });
  }
</script>
<script>

</script>

</html>
