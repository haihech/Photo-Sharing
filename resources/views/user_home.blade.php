@extends('header')
@section('css')
	<style>
		.menu_user{
			display: inline-block;
			font-size: 18px;
			padding: 10px 20px;
			cursor: pointer;
			border-bottom: 2px solid transparent;
		}
		.menu_user_active{
			border-bottom: 2px solid #3C3C3C;
		}
		.ctk{
			border:1px solid #888888;
			margin: auto;
			box-shadow: 0 0 4px rgba(0,0,0,0.5);
			border-radius: 4px;
			padding: 50px;
			padding-top: 30px;
			margin-top: 30px;
			width: 50%;
		}
		.ctk ul{
			margin: 0;
			padding: 0;
		}
		.ctk li{
			text-align: left;
			font-size: 16px;
			display: inline-block;
			width: 100%;
			border-bottom: 1px dotted #B1B1B1;
			padding: 10px 0px 0 5px;
		}
		.ctk span{
			float: right;
			font-style: italic;
			font-size: 14px;
		}
	</style>
	<style>
	    .loadItem{
	      background: #FFFFFF;border:1px solid #D1D1D1;font-size: 18px;padding: 5px 100px;
	      border-radius: 4px;
	    }
	    .loadItem:hover{
	      background: #F3F3F3;
	    }
	  </style>
@endsection
@section('content')
<div class="container" style="margin-bottom:20px; margin-top:20px;max-width:1200px;">
	<div class="row" style="text-align: center;margin-bottom: 20px;">
		<span class="menu_user menu_user_active" onclick="openTab('#userThongKe')">Thống Kê</span>
	  	<span class="menu_user" onclick="openTab('#userTC',event)">Trang Chủ</span>
	  	<span class="menu_user" onclick="openTab('#userPD',event)">Phê Duyệt</span>
	  	<span class="menu_user" onclick="openTab('#userBC',event)">Bình Chọn</span>
	  	<span class="menu_user" onclick="openTab('#userK',event)">Khác</span>
		<span class="menu_user" onclick="openTab('#userSP',event)">Sai Phạm</span>
	 </div>
	<div class="collapse in row" id="userThongKe">
		<div class="ctk">
			<h3 style="text-align: center;margin-bottom: 20px;">{{Auth::user()->nickname}}</h3>
			<ul>
				<li>Ngày tham gia <span><?php $date = date_create(Auth::user()->created_at); echo date_format($date,"d/m/Y"); ?></span></li>
				<li>Điểm<span>{{Auth::user()->score}}</span></li>
				<li>Thứ hạng<span>{{Auth::user()->score}}</span></li>
				<li>Số bài đã đăng <span>{{Auth::user()->postAll->count()}}</span></li>
				<li>Số bài được lên trang chủ <span>{{Auth::user()->postTC()}}</span></li>
				<li>Số bài đang bình chọn,phê duyệt<span>{{Auth::user()->postBC()+Auth::user()->postPD()}}</span></li>
				<li>Số bài không được lên trang chủ<span>{{Auth::user()->postKTC()}}</span></li>
				<li>Tổng số được like <span>{{Auth::user()->totalLike()}}</span></li>
				<li>Số bài bị báo cáo sai phạm <span>{{Auth::user()->totalReport()}}</span></li>
			</ul>
		</div>
	</div>
	<div class="collapse row" id="userTC">
		<h4 style="text-align: center;margin-bottom: 20px">Có {{Auth::user()->postTC()}} bài đăng được lên trang chủ!</h4>
		<div id="containerItemTC" class="row"></div>
	  	<div class="text-center">
	      <button class="loadItem" onclick="loadProduct('#containerItemTC',2)">Xem Thêm</button>
	  	</div>
	</div>
	<div class="collapse row" id="userPD">
		<h4 style="text-align: center;margin-bottom: 20px">Có {{Auth::user()->postPD()}} bài đăng đang đợi phê duyệt!</h4>
		<div id="containerItemPD" class="row"></div>
	  	<div class="text-center">
	      <button class="loadItem" onclick="loadProduct('#containerItemPD',0)">Xem Thêm</button>
	  	</div>
	</div>
	<div class="collapse row" id="userBC">
		<h4 style="text-align: center;margin-bottom: 20px">Có {{Auth::user()->postBC()}} bài đăng đang được bình chọn!</h4>
		<div id="containerItemBC" class="row"></div>
	  	<div class="text-center">
	      <button class="loadItem" onclick="loadProduct('#containerItemBC',1)">Xem Thêm</button>
	  	</div>
	</div>
	<div class="collapse row" id="userK">
		<h4 style="text-align: center;margin-bottom: 20px">Có {{Auth::user()->postKTC()}} bài đăng không được lên trang chủ!</h4>
		<div id="containerItemK" class="row"></div>
	  	<div class="text-center">
	      <button class="loadItem" onclick="loadProduct('#containerItemK',3)">Xem Thêm</button>
	  	</div>
	</div>
	<div class="collapse row" id="userSP">
	</div>
</div>
<script>
	function openTab (id) {
		$('.menu_user').removeClass("menu_user_active");
		$('#userThongKe,#userPD,#userSP,#userK,#userBC,#userTC').collapse('hide');
		event.target.className='menu_user menu_user_active';
		$(id).collapse('show');
	}
</script>
<script>
  function loadProduct(id,sql){
      var index=$(id).children('div').length;
      k=document.body.clientWidth;
      var n;
      if(k<480) n=6;
      else if(k<800) n=8;
      else n=9;
      $.ajax({
        url:'{{ url('/uloadItem/') }}'+'/'+sql+'/'+index+'/'+n,
        method:'GET',
        success:function(data){
          $(id).append(data);
        }
      });
    };
    loadProduct('#containerItemTC',2);
    loadProduct('#containerItemPD',0);
    loadProduct('#containerItemBC',1);
    loadProduct('#containerItemK',3);
</script>
@endsection