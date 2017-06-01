@foreach ($comments as $c)
@php
  $user=$c->user;
@endphp
<div class="subcomment" id="comment{{$c->id}}">
  <div class="subcomment-icon" style="margin:0">
    <a href="#" >
      <img src="{{ asset('/images/'.$user->avatar) }}" width="32px" height="32px" style="border:1px solid #A9A9A9;">
    </a>
  </div>
  <div class="subcomment-info">
    <div class="subcomment-author">
      <a href="#" style="margin-right: 10px;font-weight: bold">{{$user->nickname}}</a>
      <span style="margin-left: 20px;color:#9C9C9C;font-size: 11px;">{{$c->updated_at->format('d/m/Y H:i')}}</span>
    </div>
    <div>{!!$c->comment!!}</div>
    <div>
    @if(Auth::check())
    <a onclick="toggleLike({{$c->id}})" id="like{{$c->id}}" style="color:#8D8D8D;font-size: 11px;cursor: pointer;
    @if($c->isLike()!=null) font-weight:bold;color:#005DCE; @endif
    ">Thích</a>
    @else
    <a data-toggle="modal" data-target="#modalLogin" id="like{{$c->id}}" style="color:#8D8D8D;font-size: 11px;cursor: pointer;
    ">Thích</a>
    @endif
    <span style="margin-left: 10px;color:#8D8D8D;"><img src="{{ asset('images/like.png') }}" style="margin-top: -3px" alt=""> <span id='numsLike{{$c->id}}'>{{$c->likes()}}</span></span>
    
    </div>
  </div>
</div>
@endforeach