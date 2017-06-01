@extends('header')
@section('css')
<style>
	.iconavatar{
		display: inline-block;
		width: 200px;
		height: 200px;
		position: relative;
		float: right;
	}
	.iconavatar a{
		background: transparent;
		border:none;
		padding: 0;
		width: 100%;
		height: 100%;
		display: inline-block;
		position: absolute;
	}
	.iconavatar a:hover{
		background-color: rgba(0,0,0,0.5);
		background-image: url('../images/camera.png');
		background-repeat: no-repeat;
		background-position: 50%;
	}
	.iconavatar img{
		position: absolute;
		border:1px solid #0024FF;
		border-radius: 4px;
	}
	.profile{
		float: left;
		display: inline-block;
		width: 500px;
		font-size: 16px;
	}
	.abcd{
		margin-bottom: 5px;
		color:#606060;
		font-weight: bold;
	}
	.profile input,.spaninput{
		display: inline-block;
		padding:10px;
		width: 100%;
		border-radius: 4px;
		border:1px solid #C8C8C8;
		margin-bottom: 20px;
	}
	.profile input::-webkit-input-placeholder{
		font-style: italic;
		font-weight: normal;
	}
	.btabcd{
		background: #003CFF;
		padding: 10px 20px;
		color:#fff;
		border:1px solid #939393;
		border-radius: 4px;
	}
</style>
	
@endsection
@section('content')
<form action="{{ route('updateProfile') }}" method="post" enctype="multipart/form-data"  >
<input type="hidden" name="_token" value="{{ csrf_token() }}">
<div class="container" style="margin-bottom:20px; margin-top:50px;">
<div class="col-md-4">
<div class="iconavatar" >
	<input type="file" style="display: none" name="avatar" accept="image/*" onchange="loadAvatar(event)" id="file_avatar">
	<img id="imgAvatar" src="{{ asset('images/'.Auth::user()->avatar) }}" width="200" height="200" alt="avatar">
	<a title="Thay avatar" onclick="openFile()"></a>
</div>
</div>
<div class="col-md-8">
	<div class="profile">
		<div class="abcd">Nickname <span style="color:red;font-size: 14px;font-weight:normal;font-style: italic;">(có thể chỉnh sửa)</span></div>
		<input type="text" name="nickname" id="" value="{{Auth::user()->nickname}}">
		<div class="abcd">Email</div>
		<span class="spaninput">{{Auth::user()->email}}</span>
		<div class="abcd">Ngày tham gia</div>
		<span class="spaninput"><?php $date = date_create(Auth::user()->created_at); echo date_format($date,"d/m/Y"); ?></span>
		@if(Auth::user()->username)
		<div class="abcd">Tên đăng nhập</div>
		<span class="spaninput">{{Auth::user()->username}}</span>
		<div style="margin-top: 10px">
		<legend>Đổi mật khẩu</legend>
		<div class="abcd">Mật khẩu cũ</div>
		<input type="password" name="oldPassword" id="" placeholder="Old password...">
		<div class="abcd">Mật khẩu mới</div>
		<input type="password" name="password" id="" placeholder="New password..." >
		<div class="abcd">Nhập lại mật khẩu</div>
		<input type="password" name="password_confirmation" id="" placeholder="Confirm password..." >
		<legend></legend>
		</div>
		@else
		<legend style="margin-top: 10px">Tạo tài khoản</legend>
		<div class="abcd">Tên đăng nhập <span style="color:red;font-size: 14px;font-weight:normal;font-style: italic;">(Không thể chỉnh sửa sau khi tạo)</span></div>
		<input type="text" name="username" placeholder="Username..." id="" >
		<div class="abcd">Mật khẩu</div>
		<input type="password" name="password" placeholder="Password..." id="" >
		<div class="abcd">Nhập lại mật khẩu</div>
		<input type="password" name="password_confirmation" id="" placeholder="Confirm password..." >
		@endif
		<button type="submit" class="btabcd">Cập nhật</button>
	</div>
</div>
</div>
</form>
@if(session()->has('failUpdate'))
<script>
	alert('{{session()->get('failUpdate')}}');
</script>
@endif
<script>
	function openFile(){
		var elem = document.getElementById('file_avatar');
	   if(elem && document.createEvent) {
	      var evt = document.createEvent("MouseEvents");
	      evt.initEvent("click", true, false);
	      elem.dispatchEvent(evt);
	   }
	}
	function loadAvatar(event){
		var tgt = event.target || window.event.srcElement,
        files = tgt.files;
	    if (FileReader && files && files.length) {
	        var fr = new FileReader();
	        fr.onload = function () {
	            document.getElementById('imgAvatar').src = fr.result;
	        }
	        fr.readAsDataURL(files[0]);
	    }
	}
</script>
@endsection