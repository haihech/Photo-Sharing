<div>
  <h3 class="text-info">Bài đăng chờ phê duyệt ( <?php echo count($posts) ?> bài )</h3>
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
      <th><center>Loại</center></th>
      <th><center>Lượt xem</center></th>
      <th><center>Duyệt</center></th>
      <th><center>Hủy</center></th>
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
        <a class="example-image-link" data-lightbox="img" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32">
        </a>
      </center></td>
      <td style="width: 200px"><center>{{ $post->title }}</center></td>
      <td><center>{{$post->loai}}</center></td>
      <td style="width: 100px"><center><?php echo number_format($post->views)?></center></td>
      <td><center><button class="btn btn-primary btn-sm" onclick="confirmPost({{$post->id}})">Duyệt</button></center></td>
      <td><center><button class="btn btn-danger btn-sm" onclick="cancelPost({{$post->id}})">Hủy</button></center></td>
    </tr>
    @endforeach
  </tbody>
</table>
<br/><br/><br/><br/>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>