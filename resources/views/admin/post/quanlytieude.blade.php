@extends('admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">

    <div class="col-md-5">
      <h3 class="text-info">Danh sách danh mục ảnh</h3>
    </div>
    <br/>
    <div class="col-md-2">
      <button type="button" style="font-size: 12px" class="btn btn-primary" data-toggle="modal" data-target="#newAccount">
        Thêm mới
      </button>
      <div class="modal fade" id="newAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Thông tin danh mục</h4>
            </div>
            <div class="modal-body">


              <form class="form-horizontal" method="post" action="{{ url('quan-ly-danh-muc/them-moi') }}">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="ht_them">Tên danh mục:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="ht_them" name="ht_them" placeholder="Nhập họ tên" required="" aria-required="true">
                  </div>
                </div>
               
                <br/><br/>
                <div class="form-group">
                  <div class="col-sm-offset-4 col-sm-4">
                    <center><input type="submit" class="btn btn-success" name="them-moi" id="them-moi" value="Thêm mới"></center>
                    {{ csrf_field() }}
                  </div>
                </div>
              </form>
              <br/><br/>
            </div>

          </div>
        </div>
      </div>
    </div>

    <br/><br/>
    
  </div>
  <br/><br/>
  <table class="table table-hover table-bordered table-striped" id="myTable">

    <thead>
      <tr>
        <th><center>STT</center></th>
        <th><center>Mã danh mục</center></th>
        <th><center>Loại danh mục</center></th>
        <th><center>Cập nhật</center></th>
        <th><center>Xóa</center></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $STT=0;
      ?>
      @foreach($categorys as $admin)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td><center>{{ $admin->id }}</center></td>
        <td><center>{{ $admin->type }}</center></td>
        <td><center>
          <button type="button" style="font-size: 12px" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myAccount-{{$admin->id}}">
            Edit
          </button>
        </center>
        <!-- Modal -->
        <div class="modal fade" id="myAccount-{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Thông tin khoản</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" method="post" action="{{ url('quan-ly-danh-muc/cap-nhat', ['id' => $admin->id]) }}">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="ht">Tên danh mục:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="ht" name="ht" value="{{ $admin->type }}" required="" aria-required="true">
                    </div>
                  </div>
                  
                  <br/><br/><br/>
                  <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                      <center><input type="submit" class="btn btn-success" name="cap-nhat" id="cap-nhat" value="Cập nhật"></center>
                      {{ csrf_field() }}
                    </div>
                  </div>
                </form>
                <br/><br/>
              </div>

            </div>
          </div>
        </div>

      </td>

    <td><center><a href="#" class="btn btn-danger btn-sm">Delete</a></center></td>
  </tr>
  @endforeach

</tbody>

</table>
<br/><br/><br/><br/>
</div>

<script >
   var x= document.getElementById("baidang");
    x.className="nav nav-second-level collapse in";
    x.setAttribute('aria-expanded','true');
    x.style.height="auto";
    x.getElementsByTagName("a")[3].className="active";

</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection