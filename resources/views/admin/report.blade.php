@extends('admin.index')

@section('content')
<div class="col-md-12 affix-content">
  <div class="main-right">
    <div>
      <h3 class="text-info">Bài đăng có report ( {{$i}} bài )</h3>
    </div>

    <br/><br/>
    <table class="table table-hover table-bordered table-striped" id="myTable">
      <thead>
        <tr>
          <th><center>STT</center></th>
          <th><center>Mã bài đăng</center></th>
          <th><center>Ngày đăng</center></th>
          <th><center>Người đăng</center></th>
          <th><center>Ảnh</center></th>
          <th><center>Tiêu đề</center></th>
          <th><center>Lượt xem</center></th>
          <th><center>Chi tiết</center></th>
          <th><center>Duyệt</center></th>
          <th><center>Xóa</center></th>
        </tr>
      </thead>
      <tbody>
        <?php $STT=0 ?>
        @foreach($posts as $post)
        <tr>
          <th><center><?php echo ++$STT ?></center></th>

          <td style="width: 120px"><center>{{$post->id}}</center></td>
          <td style="width: 120px"><center><?php $date = date_create($post->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td style="width: 150px"><center>{{$post->ten}}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $post->img }}" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32" alt="{{ $post->img }}">
          </a>
          </center></td>
          <td style="width: 150px"><center>{{ $post->title }}</center></td>
          <td style="width: 100px"><center><?php echo number_format($post->views)?></center></td>
          <td style="width: 90px;"><center><a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal-{{$post->id}}">Xem</a></center>

          <!-- Modal -->
            <div class="modal fade" id="myModal-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Danh sách báo cáo</h4>
                  </div>
                  <div class="modal-body">
                      <table class="table table-hover table-bordered table-striped" id="myTable-{{$post->id}}">
                        <thead>
                          <tr>
                            <th><center>STT</center></th>
                            <th><center>Người báo cáo</center></th>
                            <th><center>Thời gian</center></th>
                            <th><center>Loại</center></th>
                            <th><center>Lý do</center></th>
                            <th><center>Trạng thái</center></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $stt=0 ?>
                          @foreach($arr[$STT] as $detail)
                          <tr>
                            <td><center><?php echo ++$stt ?></center></td>
                            <td><center>{{ $detail->ten }}</center></td>
                            <td><center><?php $date = date_create($detail->created_at); echo date_format($date,"h:i:s d/m/Y"); ?></center></td>
                            <td><center>{{ $detail->type }}</center></td>
                            <td style="width: 250px;"><center>{{ $detail->reason }}</center></td>
                            <?php if($detail->status == 0) $tt = 'Chờ duyệt'; else $tt = 'Đã duyệt'; ?>
                            <td><center><?php echo $tt ?></center></td>
                          </tr>
                          @endforeach
                          </tbody>

                        </table>
                        <br/><br/>

                        <script >
                          $(document).ready(function() {
                            $('#myTable-{{$post->id}}').DataTable();
                          } );
                        </script>

                      <center><button style="margin-left: 40px" data-dismiss="modal" class="btn btn-warning">Đóng</button></center>

                      <br/><br/>

                  </div>

                </div>
              </div>
            </div>

          </td>

          <td><center><a href="{{ url('bao-cao/xac-nhan', ['id'=>$post->id]) }}" class="btn btn-success btn-sm">Duyệt</a></center></td>
          <td><center><a href="{{ url('danh-sach-bai-dang/xoa', ['id'=>$post->id]) }}" class="btn btn-danger btn-sm">Xóa</a></center></td>

        </tr>
        @endforeach
      </tbody>
    </table>
    <br/><br/><br/><br/>

  </div>  
</div>


<script >
  var x= document.getElementById("report");
  x.getElementsByTagName("a")[0].className="active";
</script>

 
<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>


@endsection
