@foreach ($comments as $c)
@php
  $user=$c->user;
@endphp
<div class="comment" id="comment{{$c->id}}">
  <div class="comment-icon">
    <a href="#" >
      <img src="{{ asset('/images/'.$user->avatar) }}" width="40px" height="40px" style="border:1px solid #F4F4F4;">
    </a>
  </div>
  <div class="attribution-info" style="display: inline-block;padding:0 20px;width: 100%">
    <p class="comment-author" style="margin: 0">
      <a href="#" style="margin-right: 10px">{{$user->nickname}}</a>
    </p>
    <div class="comment-content" style="padding: 0;margin: 0;width: 100%">{!!$c->comment!!}</div>
    <div class="comment-reply" >
    @if(Auth::check())
    <a onclick="toggleLike({{$c->id}})" id="like{{$c->id}}" style="margin-right: 5px;color:#8D8D8D;
    @if($c->isLike()!=null) font-weight:bold;color:#005DCE; @endif
    ">Thích</a>
    @else
    <a data-toggle="modal" data-target="#modalLogin" id="like{{$c->id}}" style="margin-right: 5px;color:#8D8D8D;
    ">Thích</a>
    @endif
    <a style="color:#8D8D8D;" class="bt" data-toggle="collapse" data-target="#replyComment{{$c->id}}">Trả lời</a>
    <span style="margin-left: 10px;color:#8D8D8D;"><img src="{{ asset('images/like.png') }}" style="margin-top: -3px" alt=""> <span id='numsLike{{$c->id}}'>{{$c->likes()}}</span></span>
    <span style="margin-left: 10px;color:#8D8D8D;"><img src="{{ asset('images/chat.png') }}" style="margin-top: -2px" alt=""> <span id='numsComment{{$c->id}}'>{{count($c->subIdComments())}}</span></span>
    <span class="date">{{$c->updated_at->format('d/m/Y H:i')}}</span>
    </div>
    <div id="replyComment{{$c->id}}" class="collapse">
        <div class="inputReply">
        @if(Auth::check())
          <img src="{{ asset('/images/'.Auth::user()->avatar) }}" style="border:1px solid #A9A9A9;width:32px;height: 32px;position: absolute;">
          <textarea id="newComment{{$c->id}}" onkeydown="postSubComment(event,{{$c->id}})" placeholder="Trả lời..." style="overflow: hidden;width: 90%;height: 32px;padding: 7px;border-radius: 0;margin-top:1px;margin-left:35px;font-size: 12px"></textarea>
        @else
            <img src="{{ asset('/images/account.png') }}" style="border:1px solid #8E8E8E;width:32px;height: 32px;position: absolute;">
           <textarea id="" placeholder="Trả lời..." onclick="$('#modalLogin').modal('show');" style="overflow: hidden;width: 90%;height: 32px;padding: 6px;border-radius: 0;margin-top:1px;margin-left:35px;font-size: 12px"></textarea>
        @endif
        </div>
        <div id="containerSubComment{{$c->id}}"></div>
        <div id="getSubComment{{$c->id}}" style="margin-top: 10px"><a onclick="getSubComment({{$c->id}})" style="cursor: pointer;color:#9E9E9E;">Xem thêm bình luận...</a></div>
    </div>
  </div>
</div>
@endforeach