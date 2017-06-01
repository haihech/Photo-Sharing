@extends('admin.index')
@section('content')
<div class="col-md-12 affix-content">
  <div class="main-right">
    <div>
    <br>
      <div class="col-md-5">
        <form action="{{ route('timkiemnguoidung') }}" method="get">

          <div class="input-group search-bar">
            <input type="text" id="user" name="user" class="form-control search-field" placeholder="Người dùng...">
            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Tìm kiếm!" role="button">
            </div>
          </div>
        </form>
      </div>
    </div>
    <br/><br/><br/><br/>
    @if(!empty($listUser))

    <br/>
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã tài khoản</center></th>
          <th><center>Tên</center></th>
          <th><center>Nickname</center></th>
          <th><center>Email</center></th>
          <th><center>Avatar</center></th>
          <td><center>Trạng thái</center></td>
          <th><center>Ngày đăng ký</center></th>
          <td><center>Khóa</center></td>
          
        </tr>
      </thead>
      <tbody>
        <?php $stt=0 ?>
        @foreach($listUser as $user)
        <tr>
          <th style="width: 50px;"><center><?php echo ++$stt ?></center></th>

          <td><center>{{$user->id}}</center></td>
          <td><center>{{ $user->username }}</center></td>
          <td><center>{{$user->nickname}}</center></td>
          <td><center>{{ $user->email }}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $user->avatar }}" href="{!! asset('/images/'.$user->avatar) !!}" >
          <img src="{!! asset('/images/'.$user->avatar) !!}" width="32" height="32" alt="{{ $user->avatar }}">
          </a>
          </center></td>
          <?php if($user->status == 1) $tt = 'Hoạt động'; else $tt = 'Khóa'; ?>
          <td><center><?php echo $tt; ?></center></td>
          <td><center><?php $date = date_create($user->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td><center><a href="{{ url('nguoi-dung/khoa-tai-khoan', ['id'=>$user->id]) }}" class="btn btn-warning btn-sm">Khóa</a></center></td>
        </tr>
        @endforeach
      </tbody>
    </table>
   @endif
    <br/><br/>


  </div>  
</div>


<script>
   $(document).ready(function() {
    
    src = "{{ route('searchajax_user') }}";
     $("#user").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                }
            });
        },
        min_length: 2,
       
    });
  });
</script>

<script>
    var x= document.getElementById("nguoidung");
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>
@endsection

