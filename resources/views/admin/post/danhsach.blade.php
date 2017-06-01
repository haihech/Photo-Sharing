@extends('admin.index')

@section('content')

<div class="col-md-12">
  <div class="main-right">
    
      <br/>
      <div class="col-md-9">
      <form action="{{ route('timkiembaidang') }}" method="get" class="navbar-form">
      <div class="col-md-3">
          <table>
            <tr>
              <td><p>
                <select class="selectpicker form-control" style="width: 150px" name="selected">
                <option value="9">Chọn loại</option>
                <option value="8">Tất cả</option>
                <option value="0">Chờ phê duyệt</option>
                <option value="1">Đã phê duyệt</option>
                <option value="2">Đăng trang chủ</option>
                </select>
              </p></td>
            </tr>

          </table>
        </div>
          <div class="input-group search-bar">
            <input style="width: 250px;" type="text" id="post" name="post" class="form-control search-field" placeholder="Mã bài đăng, người đăng...">
            <div class="input-group-btn">
              <input type="submit" class="btn" name="timkiembaidang" value="Tìm kiếm" id="icon-search" style="text-indent: 17px">
            </div>
          </div>
      </form>

    </div>

  <br/><br/><br/><br/>
  @if(!empty($posts))
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
          <th><center>Xóa</center></th>
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

          <?php $status = $post->status; if($status == 0) $tt='Chờ phê duyệt'; elseif ($status == 2) {
            $tt='Đăng trang chủ';
          } else {
            $tt='Đã phê duyệt';
          }?>

          <td style="width: 150px;"><center>{{ $tt }}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $post->img }}" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32">
          </a>
          </center></td>
          <td style="width: 200px"><center>{{ $post->title }}</center></td>
          <td><center>{{$post->loai}}</center></td>
          <td style="width: 100px"><center><?php echo number_format($post->views)?></center></td>
          <!-- <td><center><a href="{{ url('danh-sach-bai-dang/cap-nhat', ['id'=>$post->id]) }}" class="btn btn-success btn-sm">Sửa</a></center></td> -->
          <td><center><a href="{{ url('danh-sach-bai-dang/xoa', ['id'=>$post->id]) }}" class="btn btn-danger btn-sm">Xóa</a></center></td>
          
        </tr>
        @endforeach
      </tbody>
    </table>
    <br/><br/><br/><br/><br/><br/>
  @endif
  
</div>

<script>
   $(document).ready(function() {
    
    src = "{{ route('searchajax_post') }}";
     $("#post").autocomplete({
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

<script >
   var x= document.getElementById("baidang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[2].className="active";

</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection