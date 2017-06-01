<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Photo Sharing</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> -->
    <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTable/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTable/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome-4.6.3/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome-4.6.3/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/jquery.ui.autocomplete.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTable/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/dataTable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('js/sb-admin-2.js') }}"></script>
    <script src="{{ asset('js/number_format.js') }}"></script>
    <script src="{{ asset('js/morris.min.js') }}"></script>
    <script src="{{ asset('js/raphael.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/lightbox.min.css') }}">
    <script src="{{ asset('js/lightbox.min.js') }}"></script>

    @yield('css')

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Trang quản trị</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Phạm Tiến Dũng</strong>
                                    <span class="pull-right text-muted">
                                        <em>Hôm qua</em>
                                    </span>
                                </div>
                                <div>Xin chào...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Đọc tất cả tin nhắn</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Nhiệm vụ 1</strong>
                                        <span class="pull-right text-muted">40% Hoàn thành</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Xem tất cả nhiệm vụ</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">

                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Cập nhật tài khoản
                                    <span class="pull-right text-muted small">4 phút trước</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Xem tất cả thông báo</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"> {{ Session::has('admin') ? Session::get('admin')->name : '' }} 
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Tài khoản</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Cài đặt</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url('logout-admin') }}"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a>
                        </li>
                    </ul>
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Tìm kiếm...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li style="font-size: 16px" id="trangchu">
                            <a href="{{ route('home-admin') }}"><i class="fa fa-home fa-fw  menu-hinh"></i> Trang chủ</a>
                        </li>

                        @if(strpos(Session::get('str_roles'),"quyen-01") !== false)
                        <li>
                            <a href="#" style="font-size: 16px"><i class="fa fa-bars fa-fw  menu-hinh"></i> Bài đăng<span class="fa arrow"></span></a>
                            
                            <ul class="nav nav-second-level" id="baidang">
                                <li><a href="{{ route('chopheduyet') }}">Chờ phê duyệt</a></li>
                                <li><a href="{{ route('duyetbaitrangchu') }}">Đăng lên trang chủ</a></li>
                                <li><a href="{{ route('danhsachbaidang') }}">Danh sách</a></li>
                                <li><a href="{{ route('quanlydanhmuc') }}">Quản lý danh mục</a></li>
                                    
                            </ul>
                            
                            <!-- /.nav-second-level -->
                        </li>
                        @endif

                        @if(strpos(Session::get('str_roles'),"quyen-02") !== false)
                        <li style="font-size: 16px" id="report">
                            <a href="{{ route('report') }}"><i class="fa fa-remove fa-fw  menu-hinh"></i> Report</a>
                        </li>
                        @endif

                        @if(strpos(Session::get('str_roles'),"quyen-04") !== false)
                        <li style="font-size: 16px" id="thongke">
                            <a href="{{ route('thongke') }}"><i class="fa fa-bug fa-fw  menu-hinh"></i> Thống kê</a>
                        </li>
                        @endif
                        
                        @if(strpos(Session::get('str_roles'),"quyen-03") !== false)
                        <li id="nguoidung">
                            <a href="{{ route('nguoidung') }}" style="font-size: 16px"><i class="fa fa-user fa-fw  menu-hinh" ></i> Người dùng</a>
                        </li>
                        @endif

                        @if(Session::get('admin')->id == 'admin')
                        <li id="taikhoan">
                            <a href="{{ route('taikhoanadmin') }}" style="font-size: 16px"><i class="fa fa-user-plus fa-fw  menu-hinh"></i> Tài khoản</a>
                        </li>
                        @endif

                       

              
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>



        <div id="page-wrapper">
           <div class="row">
            @yield('content')
            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

</body>

</html>
