@extends('header')

@section('content')

<div class="container" style="margin-bottom:20px; margin-top:20px;max-width:1200px;">
  <div class="row">
    <div class="col-md-12">
      <h3> Ảnh {{$sql}}</h3>
    </div>
  </div>
  
  <div id="containerItem" class="row"></div>
 
</div>
<div class="row" style="margin-bottom: 50px">
  <div class="text-center">
      <style>
        .loadItem{
          background: #FFFFFF;border:1px solid #D1D1D1;font-size: 18px;padding: 5px 100px;
          border-radius: 4px;
        }
        .loadItem:hover{
          background: #F3F3F3;
        }
      </style>
      <button class="loadItem" onclick="loadProduct()">Xem Thêm</button>
  </div>
</div>

<script>
  var sql='{{$sql}}';
  function loadProduct(){
      var index=$('#containerItem').children('div').length;
      k=document.body.clientWidth;
      var n;
      if(k<480) n=6;
      else if(k<800) n=8;
      else n=9;
      $.ajax({
        url:'{{ url('/loadItem/') }}'+'/'+sql+'/'+index+'/'+n,
        method:'GET',
        success:function(data){
          $('#containerItem').append(data);
        }
      });
    };
    loadProduct();
</script>



@endsection