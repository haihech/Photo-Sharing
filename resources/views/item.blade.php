@foreach ($list as $e)
  @php
    $likes=$e->countLikes();
    $comments=$e->countComments();
  @endphp
  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4" >
    <div class="thumbnail bootsnipp-thumb">
        <p class="pull-right view-counts hidden-md">
           <i class="fa fa-eye">
            @if($e->views<1000)
              {{$e->views}}
            @else
              {{$e->views/1000 .'.'. ($e->views%1000)/100}}K
            @endif
            </i>

            <i class="fa fa-thumbs-up">
            @if($likes<1000)
              {{$likes}}
            @else
              {{$likes/1000 .'.'. ($likes%1000)/100}}K
            @endif
            </i>

            <i class="fa fa-comment">
              @if($comments<1000)
              {{$comments}}
            @else
              {{$comments/1000 .'.'. ($comments%1000)/100}}K
            @endif
            </i> 
        </p>
        <p class="lead snipp-title">
          {{$e->user->nickname}}
         </p>
     
      <a href="{{url('photos/detail/'.$e->id)}}">
        <img alt="Ảnh đẹp" src="{{asset('images/').'/'.$e->img}}" style="height: 240px">
      </a>
      <div class="caption">
        {{$e->title}}
      </div>
    </div>
  </div>
  @endforeach

