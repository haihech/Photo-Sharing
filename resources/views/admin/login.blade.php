<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>Đăng nhập</title>
		<!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	</head>
	<body>
     
    <div class="container">
      <div class="main">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <h1>Đăng nhập</h1>
            @if(count($errors) > 0)
               <div class="alert alert-danger">
                 @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                 @endforeach
               </div>
            @endif
            <form action="{{ url('signin-admin')}}" method="post">
              <div class="form-group">
                <label for="manv">User name</label>
                <input type="text" name="manv" id="manv" class="form-control">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
          
              <button type="submit" class="btn btn-success pull-right">Đăng nhập</button>
              {!! csrf_field() !!}
            </form>
          </div>
        </div>
      </div>
      
    </div>
		<script src="{{asset('js/bootstrap.min.js')}}"></script>
    
	</body>
</html>
