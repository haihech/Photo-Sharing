@extends('admin.index')

@section('content')

<div class="col-md-12">
  <div class="main-right">
    <br/><br/>

  <div>
    <center><h4 class="text-info">Danh sách bài được yêu thích nhất</h4></center>
  </div>

  <br/><br/>
  @if(!empty($posts))
  <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã bài</center></th>
          <th><center>Ngày đăng</center></th>
          <th><center>Người đăng</center></th>
          <th><center>Ảnh</center></th>
          <th><center>Tiêu đề</center></th>
          <th><center>Loại</center></th>
          <th><center>Lượt xem</center></th>
          <th><center>Lượt like</center></th>
        </tr>
      </thead>
      <tbody>
        
        <?php $STT=0 ?>
        @foreach($posts as $post)
        <tr>
          <th><center><?php echo ++$STT ?></center></th>

          <td style="width: 80px"><center>{{$post->id}}</center></td>
          <td style="width: 120px"><center><?php $date = date_create($post->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td style="width: 150px"><center>{{$post->ten}}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $post->img }}" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32">
          </a>
          </center></td>
          <td style="width: 200px"><center>{{ $post->title }}</center></td>
          <td><center>{{$post->loai}}</center></td>
          <td style="width: 100px"><center><?php echo number_format($post->views)?></center></td>
          <td style="width: 100px"><center><?php echo number_format($post->likes)?></center></td>
          
        </tr>
        @endforeach

        
      </tbody>
      
    </table>
    <br/><br/>
      <div><center><a href="{{ url('dua-len-trang-chu/cap-nhat') }}" class="btn btn-primary">Đăng lên trang chủ</a></center></div>
    @else
       <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã bài</center></th>
          <th><center>Ngày đăng</center></th>
          <th><center>Người đăng</center></th>
          <th><center>Trạng thái</center></th>
          <th><center>Ảnh</center></th>
          <th><center>Tiêu đề</center></th>
          <th><center>Loại</center></th>
          <th><center>Lượt xem</center></th>
          <th><center>Lượt like</center></th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    
    @endif


    <br/><br/><br/><br/><br/><br/>
 
  
</div>

<script >
   var x= document.getElementById("baidang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[1].className="active";

</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection