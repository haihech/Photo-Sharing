@extends('header')
@section('css')
<link href="{{asset('css/rollup-fac65cc2.css')}}" rel="stylesheet">
<style>
  .comment-reply{
      font-size: 12px;
      margin-bottom: 0;
      margin-top: 5px;
  }
  .comment-reply a{
    text-decoration: none;
    cursor: pointer;
  }
  .comment-reply span.date{
    margin-left: 20px;
    color:#9C9C9C;
  }
  [id^=replyComment]{
    width: 100%;
      border-left: 2px solid #D7D7D7;
      margin-left:-10px;
    padding-left: 10px;
    margin-top: 5px;
    font-size: 12px
  }
  .inputReply{
    width:100%;
    display: inline-block;
  }
  .subcomment{
    margin-top: 5px;
    display: inline-block;
    position: relative;
  }
  .subcomment-icon{
    position: absolute;
  }
  .subcomment-info{
    padding-left: 35px;
  }
  .subcomment-author{

  }
</style>
@endsection

@section('content')

<div class="container" style="margin-bottom:20px; margin-top:20px;">
  <div class="row">
        <div  style="width: 100%;text-align:center;background: #222222;padding:30px 10% 0 10%">
            <img  height="auto" style="max-width:90%;" src="{{ asset('images/'.$post->img) }}"
               class="main-photo" alt="{{$post->img}}">
          <div class="row" style="margin-top: 5px" >
                <a title="Thích Ảnh" class="btn" @if(Auth::check())onclick="toggleLikePost()" @else data-toggle="modal" data-target="#modalLogin" @endif>
                  <i id="btLike" class="mylike @if($post->isLike()==null) dislike @else like @endif"></i>
                </a>
                <a title="Thêm vào yêu thích" class="btn " @if(Auth::check()) onclick="toggleSavePost()" @else data-toggle="modal" data-target="#modalLogin" @endif>
                  <i id="btSave" class="mysave @if($post->isSave()==null) dissave @else save @endif"></i>
                </a>
                <a href="{{ asset('images/'.$post->img) }}" title="Tải xuống ảnh này"  class="btn" download>
                  <i class="myicon-download" ></i>
                </a>
          </div>
        </div>
  </div>
  <div class="row">
    <div class=" sub-photo-view">
        <div class="sub-photo-left-view" style="float:left;margin:0;width: 45%;">
          <div class="attribution-view clear-float photo-attribution" >
              <div class="avatar person medium no-outline comment-icon circle-icon" >
                <a href="#" >
                  <img src="{{ asset('/images/'.$post->user->avatar) }}" width="48" height="48">
                </a>
              </div>
              <div class="attribution-info" style="display: inline-block;">
                <a href="#" class="owner-name truncate" data-track="attributionNameClick" data-rapid_p="54">{{$post->user->nickname}}</a>
                <br>
                <p style=" font-size: 16px;margin-top: 25px;margin-left: 5px;word-break: break-all;">{{$post->title}}</p>
              </div>
          </div>
        </div>
        <div class="sub-photo-right-view" style="float:left;width: 45%;margin:20px 0 20px 10%;">
          <div class="sub-photo-right-row1">
            <div class="sub-photo-right-stats-view">
              <div class="view-count">
                <span class="view-count-label" >
                  <?php echo number_format($post->views); ?></span>
                <span class="stats-label">lượt xem</span>
              </div>
              <div class="fave-count">
                <span class="fave-count-label" id="numsLike">
                  <?php echo number_format($post->countLikes()); ?>
                </span>
                <span class="stats-label">lượt yêu thích</span>
              </div>
              <div class="comment-count">
                <span class="comment-count-label" id="numsComment">
                  <?php echo number_format($post->countComments()); ?></span>
                  <span class="stats-label">bình luận</span>
              </div>
            </div>
            <div class="sub-photo-date-view"  >
              <p class="date-taken" >
                  Được tải lên vào {{$post->getDay()}} tháng {{$post->getMonth()}}, {{$post->getYear()}}
              </p>
            </div>
            <div style="clear: both;"></div>
          </div>
        </div>
    </div>
  </div>
  <div class="row" style="margin-bottom: 100px; padding: 0;">
          <div class="sub-photo-comments-view" style="max-width: 550px;margin-left: 0;background: #fff;padding: 10px 0;border-radius: 4px" >
            <div class="comments-holder order-chronological photosInComments">
              <div class="comments-form">
                @if(Auth::check())
                  <div class="comment-icon">
                    <img src="{{ asset('/images/'.Auth::user()->avatar) }}" style="border:1px solid #8E8E8E;width:40px;height: 40px;">
                  </div>
                  <div class="comment-form-field">
                    <textarea  name="comment" id="newComment" placeholder="Thêm bình luận" style="width: 100%;height: 60px;overflow: hidden;resize: vertical;"></textarea>
                    <div class="comment-arrow"></div>
                  </div>
                @else
                  <div class="comment-icon">
                    <img src="{{ asset('/images/account.png') }}" style="border:1px solid #8E8E8E;width:40px;height: 40px;">
                  </div>
                  <div class="comment-form-field">
                    <textarea onclick="$('#modalLogin').modal('show');" name="comment" id="newComment" placeholder="Đăng nhập để bình luận" style="width: 100%;height: 60px"></textarea>
                  </div>
                @endif
               
              </div>
              <div class="comments" id="containnerComment"></div>
              <div id="getCommentPost" style="text-align: center;margin-top: 20px"><a onclick="getComment()" style="cursor: pointer;">Tải thêm bình luận...</a></div>
            </div>
          </div>
  </div>
  <script>
    document.getElementById('newComment').onkeydown = function postComment(event){
      var x = event.which || event.keyCode;
      var comment=$('#newComment').val();
      if(x==13){//enter
        if(event.shiftKey)
            return true;
         else{
            comment=comment.replace(new RegExp('\r?\n','g'),'<br>');
            $.ajax({
              url:'{{ url('postComment/').'/'.$post->id }}'+'/'+comment,
              method:'GET',
              success:function(data){
                $( "#containnerComment" ).prepend(data);
                var n=Number($('#numsComment').text());
                $('#numsComment').text(n+1);
                $('#newComment').val('');
              }
            });
            return false;
         }
      } 
    }

    function postSubComment(event,idComment){
      var x = event.which || event.keyCode;
      var comment=event.target.value;

      if(x==13){//enter
        if(event.shiftKey){
        }else{
          comment=comment.replace(new RegExp('\r?\n','g'),'<br>');
          $.ajax({
            url:'{{ url('postComment/').'/'.$post->id }}'+'/'+comment+'/'+idComment,
            method:'GET',
            success:function(data){
              $( "#containerSubComment"+idComment).prepend(data);
              var n=Number($('#numsComment'+idComment).text());
              $('#numsComment'+idComment).text(n+1);
              event.target.value='';
            }
          });
          return false;
        }
      }
    }
    function getComment(){
      var n = $('#containnerComment').children().length;
      $.ajax({
        url:'{{ url('getComment/').'/'.$post->id }}'+'/'+n+'/5',
        method:'GET',
        success:function(data){
          if(data==-1) $('#getCommentPost').hide();
          else $( "#containnerComment" ).append(data);
        }
      });
    }

    function getSubComment(idComment){
      var n=$('#containerSubComment').children().length;
      $.ajax({
        url:'{{ url('getComment/').'/'.$post->id }}'+'/'+n+'/10/'+idComment,
        method:'GET',
        success:function(data){
          if(data==-1) $('#getSubComment'+idComment).hide();
          else $( "#containerSubComment"+idComment).append(data);
        }
      });
    }

    window.onload=getComment();

    function toggleLikePost(){
        var a=document.getElementById('btLike');
        var n=Number($('#numsLike').text());
        if(a.className.indexOf('dislike') !== -1){
            a.className='mylike like';
            $('#numsLike').text(n+1);
        }else{
          a.className='mylike dislike';
          $('#numsLike').text(n-1);
        }
       $.ajax({
        url:'{{ url('postLike/'.$post->id) }}',
        method:'GET',
        success:function(data){
          
        }
      });
    }

    function toggleSavePost(){
        var a=document.getElementById('btSave');
          if(a.className.indexOf('dissave') !== -1){
            a.className='mysave save';
        }else{
          a.className='mysave dissave';
        }
       $.ajax({
        url:'{{ url('postSave/'.$post->id) }}',
        method:'GET',
        success:function(data){
          
        }
      });
    }
    function toggleLike(idComment){
        var a=document.getElementById('like'+idComment);
        var n=Number($('#numsLike'+idComment).text());
        if(a.style.fontWeight=='bold'){
            a.style.fontWeight='';
            a.style.color="#8D8D8D";
            $('#numsLike'+idComment).text(n-1);
        }else{
             a.style.fontWeight='bold';
            a.style.color="#005DCE";
             $('#numsLike'+idComment).text(n+1);
        }
       $.ajax({
        url:'{{ url('postLikeComment/') }}'+'/'+idComment,
        method:'GET',
        success:function(data){
          
        }
      });
    }
  </script>
   {{--  <div class="view footer-full-view requiredToShowOnServer" style="width: 100px;">
          <footer class="foot">
            <div class="foot-container" role="contentinfo">
              <div class="foot-top-row">
                <ul class="foot-nav-ul">


                  <li class="foot-li"><a href="#" data-track="footer-about" data-rapid_p="54">Giới thiệu</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-jobs" data-rapid_p="55">Việc làm</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-blog" data-rapid_p="56">Blog</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-mobile" data-rapid_p="57">Di động</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-developers" data-rapid_p="58">Nhà phát triển</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-guidelines" data-rapid_p="59">Quy tắc</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-feedback" data-rapid_p="60">Phản hồi</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-abuse" data-rapid_p="61">Báo cáo vi phạm</a></li>
                  <li class="foot-li"><a href="#" data-track="footer-forum" data-rapid_p="62">Diễn đàn trợ giúp</a></li>
                  <li class="foot-li lang-switcher">
                    <a href="#" data-track="footer-language" data-rapid_p="63">Tiếng Việt</a>
                    <span class="arrow"></span>
                  </li>
                </ul>
              </div>
              <div class="foot-bottom-row">
                <div class="foot-yahoo">
                  <ul class="foot-nav-ul">
                    <li class="foot-li"><a href="#" data-track="footer-privacy" data-rapid_p="64">Sự riêng tư</a></li>
                    <li class="foot-li"><a href="#" data-track="footer-terms" data-rapid_p="65">Điều khoản</a></li>
                    <li class="foot-li"><a href="#" data-track="footer-safely" data-rapid_p="66">Yahoo An Toàn</a></li>
                    <li class="foot-li"><a href="#" data-track="footer-help" data-rapid_p="67">Trợ giúp</a></li>
                  </ul>
                </div>

                <div class="foot-company">
                  Photo Sharing, <a href="#" data-rapid_p="68">một website chia sẻ ảnh</a>
                </div>

                <div class="foot-social">
                  <ul class="foot-nav-ul">
                    <li><a target="_blank" href="#" aria-label="Tumblr" data-track="footer-tumblr" data-rapid_p="69">
                      <svg class="ft-icon ft-tumblr"><use xmlns:xlink="#" xlink:href="#icon-tumblr"></use></svg>
                    </a></li>
                    <li><a target="_blank" href="#" aria-label="Facebook" data-track="footer-facebook" data-rapid_p="70">
                      <svg class="ft-icon ft-facebook"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-facebook"></use></svg>
                    </a></li>
                    <li><a target="_blank" href="#" aria-label="Twitter" data-track="footer-twitter" data-rapid_p="71">
                      <svg class="ft-icon ft-twitter"><use xmlns:xlink="http://www.w3.org/1999/xlink" ></use></svg>
                    </a></li>
                  </ul>
                </div>
              </div>
            </div>
          </footer>
        </div> --}}


  

</div>

@endsection