@extends('admin.index')
@section('content')

<div class="row">
<div class="col-lg-12">
	<center><h3 class="page-header" style="color: #5d5d5d;
    font-family: 'Segoe UI Light','Helvetica Neue Light','Segoe UI','Helvetica Neue','Helvetica','Trebuchet MS',Verdana,sans-serif; font-size: 24px" >Thống kê bài đăng, tương tác theo tháng</h3></center>
</div>
<!-- /.col-lg-12 -->
</div>

<div class="row">

<!-- /.col-lg-6 -->
<div class="col-lg-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span style="color: #5d5d5d;
    font-family: 'Segoe UI Light','Helvetica Neue Light','Segoe UI','Helvetica Neue','Helvetica','Trebuchet MS',Verdana,sans-serif; font-size: 16px">Tương tác</span> 
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);" id="morris"></div>
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
</div>

<div class="col-lg-6">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span style="color: #5d5d5d;
    font-family: 'Segoe UI Light','Helvetica Neue Light','Segoe UI','Helvetica Neue','Helvetica','Trebuchet MS',Verdana,sans-serif; font-size: 16px">Bài đăng</span> 
		</div>
		<!-- /.panel-heading -->
		<div class="panel-body">
			<div style="position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);" id="morris-area-chart"></div>
		</div>
		<!-- /.panel-body -->
	</div>
	<!-- /.panel -->
</div>

</div>


<script>

	new Morris.Area({
        element: 'morris-area-chart',
        data: <?php echo json_encode($listPosts);?>,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Năm 2015', 'Năm 2016'],
        hideHover: 'auto',
        resize: true
    });

    new Morris.Bar({
        element: 'morris',
        data: <?php echo json_encode($listInter);?>,
        xkey: 'y',
        ykeys: ['a', 'b', 'c'],
        labels: ['Lượt xem', 'Lượt đánh giá', 'Lượt bình luận'],
        hideHover: 'auto',
        resize: true
    });

</script>

<script >
	var x= document.getElementById("trangchu");
	x.getElementsByTagName("a")[0].className="active";
</script>


@endsection