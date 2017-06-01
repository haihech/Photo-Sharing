@extends('admin.index')
@section('content')

<div class="col-md-12 affix-content">

  <div class="main-right">
    <br/>
      <form class="navbar-form navbar-left" method="post" action="{{ route('thong_ke') }}">
        <div class=" form-horizontal">
          <div class="form-group">
              <label class="control-label col-xs-1" for="option_selected">Loại:</label>
              <div class="col-xs-2">
                <select class="selectpicker form-control" name="option_selected_avaiable" id="option_selected_avaiable">
                  <option value="1">Bài đăng</option>
                  <option value="2">Top bài đăng yêu thích</option>
                  <option value="3">Người dùng mới</option>
                </select>
              </div>

              <label class="control-label col-xs-2" for="option_selected">Thời gian:</label>
              <div class="col-xs-5">
                <select style="width: 80px" class="selectpicker form-control" name="day" id="option_selected_time">
                  <option value="0">Ngày</option>
                  <option value="1">01</option>
                  <option value="2">02</option>
                  <option value="3">03</option>
                  <option value="4">04</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
                  <option value="7">07</option>
                  <option value="8">08</option>
                  <option value="9">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  
                </select>
                <select style="width: 90px" class="selectpicker form-control" name="month" id="option_selected_time">
                  <option value="0">Tháng</option>
                  <option value="1">01</option>
                  <option value="2">02</option>
                  <option value="3">03</option>
                  <option value="4">04</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
                  <option value="7">07</option>
                  <option value="8">08</option>
                  <option value="9">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                
                </select>
                <select style="width: 80px" class="selectpicker form-control" name="year" id="option_time">
                  <option value="0">Năm</option>
                  <option value="2016">2016</option>
                  <option value="2015">2015</option>
                  <option value="2014">2014</option>
                  <option value="2013">2013</option>
                  <option value="2012">2012</option>
                  
                </select>
              </div>
          
            <div class="input-group-btn">
              <input type="submit" class="btn btn-primary" value="Thống kê" role="button" name="searchProduct">
            </div>
            {{ csrf_field() }}

           </div>

      </form>
      
  </div>

  <br/><br/><br/><br/><br/>
  @if(!empty($listPost))
    <?php if($month == 0) $tb = 'Thống kê bài đăng năm '.$year; elseif($day == 0) $tb = 'Thống kê bài đăng tháng '.$month.' - '.$year; else $tb = 'Thống kê bài đăng ngày '.$day.' - '.$month.' - '.$year; ?>
    <div>
      <center><h4 class="text-info"><?php echo $tb ?></h4></center>
    </div>

    <br/>
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
        </tr>
      </thead>
      <tbody>
        <?php $STT=0 ?>
        @foreach($listPost as $post)
        <tr>
          <th><center><?php echo ++$STT ?></center></th>

          <td style="width: 80px"><center>{{$post->id}}</center></td>
          <td style="width: 120px"><center><?php $date = date_create($post->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td style="width: 150px"><center>{{$post->ten}}</center></td>

          <?php $status = $post->status; if($status == 0) $tt='Chờ phê duyệt'; elseif ($status == 4) {
            $tt='Hủy';
          } else {
            $tt='Đã phê duyệt';
          }?>

          <td style="width: 150px;"><center>{{ $tt }}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $post->img }}" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32" >
          </a>
          </center></td>
          <td style="width: 200px"><center>{{ $post->title }}</center></td>
          <td><center>{{$post->loai}}</center></td>
          <td style="width: 100px"><center><?php echo number_format($post->views)?></center></td>
        </tr>
        @endforeach
      </tbody>
    </table>
   @endif

   @if(!empty($listLike))
    <?php if($month == 0) $tb = 'Thống kê top bài đăng yêu thích năm '.$year; elseif($day == 0) $tb = 'Thống kê top bài đăng yêu thích tháng '.$month.' - '.$year; else $tb = 'Thống kê top bài đăng yêu thích ngày '.$day.' - '.$month.' - '.$year; ?>
    <div>
      <center><h4 class="text-info"><?php echo $tb ?></h4></center>
    </div>

    <br/>
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
        <?php $STT=0 ?>
        @foreach($listLike as $post)
        <tr>
          <th><center><?php echo ++$STT ?></center></th>

          <td style="width: 80px"><center>{{$post->id}}</center></td>
          <td style="width: 120px"><center><?php $date = date_create($post->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          <td style="width: 150px"><center>{{$post->ten}}</center></td>

          <?php $status = $post->status; if($status == 0) $tt='Chờ phê duyệt'; elseif ($status == 4) {
            $tt='Hủy';
          } else {
            $tt='Đã phê duyệt';
          }?>

          <td style="width: 150px;"><center>{{ $tt }}</center></td>
          <td><center>
          <a class="example-image-link" data-lightbox="{{ $post->img }}" href="{!! asset('/images/'.$post->img) !!}" >
          <img src="{!! asset('/images/'.$post->img) !!}" width="32" height="32" >
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
   @endif

   @if(!empty($listUser))
    
    <?php if($month == 0) $tb = 'Thống kê người dùng mới năm '.$year; elseif($day == 0) $tb = 'Thống kê người dùng mới tháng '.$month.' - '.$year; else $tb = 'Thống kê người dùng mới ngày '.$day.' - '.$month.' - '.$year; ?>
    <div>
      <center><h4 class="text-info"><?php echo $tb ?></h4></center>
    </div>

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
          <th><center>Ngày đăng ký</center></th>
          
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
          <td><center><?php $date = date_create($user->created_at); echo date_format($date,"d/m/Y"); ?></center></td>
          
        </tr>
        @endforeach
      </tbody>
    </table>
   @endif
   
  
<br/><br/><br/>
</div>


<script >
  var x= document.getElementById("thongke");
  x.getElementsByTagName("a")[0].className="active";
</script>

<script >
  $(document).ready(function() {
    $('#myTable').DataTable();
  } );
</script>

@endsection