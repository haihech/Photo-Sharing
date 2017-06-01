@extends('admin.index')
@section('content')

<div class="col-md-12">

  <div class="main-right">

    <div class="col-md-5">
      <h3 class="text-info">Danh sách quản trị viên</h3>
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
              <h4 class="modal-title" id="myModalLabel">Thông tin tài khoản</h4>
            </div>
            <div class="modal-body">


              <form class="form-horizontal" method="post" action="{{ url('tai-khoan/them-moi', ['id' => $manv_them]) }}">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="manv_them">Mã nhân viên:</label>
                  <div class="col-sm-6">
                    <label class="form-control">{{ $manv_them }}</label>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="password_them">Mật khẩu:</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" id="password_them" name="password_them" placeholder="Nhập mật khẩu" required="" aria-required="true">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="ht_them">Tên:</label>
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
        <th><center>Mã tài khoản</center></th>
        <th><center>Mật khẩu</center></th>
        <th><center>Tên</center></th>
        <th><center>Cập nhật</center></th>
        
        <th><center>Quyền</center></th>
        <th><center>Xóa</center></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $STT=0;
      ?>
      @foreach($admins as $admin)
      <tr>
        <th><center><?php echo ++$STT?></center></th>
        <td><center>{{ $admin->id }}</center></td>
        <td><center>{{ $admin->password }}</center></td>
        <td><center>{{ $admin->name }}</center></td>
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
                <form class="form-horizontal" method="post" action="{{ url('tai-khoan/cap-nhat', ['id' => $admin->id]) }}">
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="ht">Mật khẩu:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="password" name="password" value="{{ $admin->password }}" required="" aria-required="true">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="ht">Tên:</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="ht" name="ht" value="{{ $admin->name }}" required="" aria-required="true">
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

      <td><center>
        <button type="button" style="font-size: 12px" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myAccountRole-{{$admin->id}}">
          Role
        </button>
      </center>
      <!-- Modal -->
      <div class="modal fade" id="myAccountRole-{{$admin->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Các quyền của {{$admin->name}}</h4>
            </div>
            <div class="modal-body">

              <form action="{{ url('tai-khoan/phan-quyen', ['id' => $admin->id]) }}" method="post">
                <table class="table table-hover table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 50px"><center><label><input type="checkbox" name="checkAll-{{ $admin->id }}" id="checkAll-{{ $admin->id }}" ></label></center></th>
                      <th style="width: 100px"><center>STT</center></th>
                      <th><center>Quyền</center></th>
                    </tr>
                  </thead>
                  <script type="text/javascript">
                      $('document').ready(function(){
                          $("#checkAll-{{ $admin->id }}").click(function(){
                               if ($(this).is(':checked')) {
                                      $(".checkbox").prop("checked", true);
                               } else {
                                      $(".checkbox").prop("checked", false);
                               }
                          });
                      });
                  </script>
                  <tbody>
                    <?php $stt=0 ?>
                    @foreach($roles as $role)
                    <tr>
                    @if(strpos($arr[$STT],(string)$role->id) !== false)
                    
                    <td><center><label><input checked="true" type="checkbox" name="quyen-{{ $admin->id }}[]" id="quyen-{{ $admin->id }}[]" class="checkbox" value="{{$role->id}}"></label></center></td>
                    @else
                    <td><center><label><input type="checkbox" name="quyen-{{ $admin->id }}[]" id="quyen-{{ $admin->id }}[]" class="checkbox" value="{{$role->id}}"></label></center></td>
                    @endif
                    
                    <td><center><?php echo ++$stt ?></center></td>
                    <td><center>{{ $role->tenquyen }}</center></td>
                    </tr>
                    @endforeach

                  </tbody>

                </table>

                <br/>
                <div>
                  <center><input type="submit" role="button" id="phanquyen-{{ $admin->id }}" name="phanquyen-{{ $admin->id }}" class="btn btn-primary" value="Xác nhận"></center>
                  {{ csrf_field() }}
                </div>
              </form>
                <br/><br/>

            </div>

          </div>
        </div>
      </div>

    </td>
    <td><center><a href="{{ url('tai-khoan/xoa', ['id'=>$admin->id]) }}" class="btn btn-danger btn-sm">Delete</a></center></td>
  </tr>
  @endforeach

</tbody>

</table>
<br/><br/><br/><br/>
</div>

<script >
    var x= document.getElementById("taikhoan");
    x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection