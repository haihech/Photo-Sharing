<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserLike;
use App\Post;
use App\UserComment;
use App\UserSubComment;
use App\UserLikeComment;
use App\Category;
use Auth;
use Redirect;
use Session;
use DB;
use Carbon\Carbon;
class HomeController extends Controller
{
	/**
	* Check login
	*/
	public function checkLoginFb($idFb,$name,$email){
		$user=User::where('email',$email)->first();
		// nếu chưa có tài khoản, tạo tk
		if(!$user){
			$img=$this->getAvatar( $idFb);
			$avatar=$this->saveAvatar($idFb,$img);
			$newAccount=User::create([
				'id_fb'=>$idFb,
				'email'=> $email,
				'nickname'=>$name,
				'username'=>$name,
				'password'=>'',
				'avatar'=>$avatar,
                'status'=>1
				]);
			$newAccount->save();
			Auth::login($newAccount);
			Auth::user()->admin=0;
		}
		// nếu có tk, login
		else{
			$user->id_fb = $idFb;
			$user->save();
			Auth::login($user);
			Auth::user()->admin=0;
		}
		return 'ok';
	}
	public function getAvatar($idFb){
		$img=file_get_contents('https://graph.facebook.com/'.$idFb.'/picture?type=large');
		return $img;
	}
	public function saveAvatar($idFb,$img){
		$file = dirname('public').'/avatar/'.$idFb.'.jpg';
		file_put_contents($file, $img);
		return $idFb.'.jpg';
	}
	/**
	* Logout
	*/
	public function logout(){
		Auth::logout();
		return redirect()->back();
	}
    public function getHome(){
    	return view('home')->with('sql','mới');
    }
    public function getHot(){
    	return view('home')->with('sql','hot');
    }
    public function getBinhChon(){
    	return view('home')->with('sql','bình chọn');
    }
    public function getHaiHuoc(){
    	return view('home')->with('sql','hài');
    }
    public function getGirlXinh(){
    	return view('home')->with('sql','girl xinh');
    }
    public function getKhac(){
    	return view('home')->with('sql','khác');
    }

    public function getType(){
    	$list=Category::all();
    	$result='';
    	foreach ($list as $value) {
    		$result.='<option>'.$value->type.'</option>';
    	}
    	return $result;
    }
    /**
    * type: new,vote, các loại trong categony
    hot trong tháng,hot trong năm,
    */
    public function loadMoreItem($type='mới',$index=0,$nums=3){
    	if($type=='mới'){
    		$list=Post::where('status','2')->orderBy('created_at')->skip($index)->take($nums)->get();
    	}else if($type=='hot'){
    		 $list= $this->getHotProduct($index,$nums);
    	}else if($type=='bình chọn'){
    		$list=Post::where('status','1')->orderBy('created_at')->skip($index)->take($nums)->get();
    	}else if($type=='hài'){
    		$type=Category::where('type','Ảnh Hài')->pluck('id')->first();
    		$list=Post::where('category_id',$type)->where('status','2')->orderBy('created_at')->skip($index)->take($nums)->get();
    	}else if($type=='girl xinh'){
    		$type=Category::where('type','Girl Xinh')->pluck('id')->first();
    		$list=Post::where('category_id',$type)->where('status','2')->orderBy('created_at')->skip($index)->take($nums)->get();
    	}else if($type=='khác'){
    		$type=Category::where('type','Khác')->pluck('id')->first();
    		$list=Post::where('category_id',$type)->where('status','2')->orderBy('created_at')->skip($index)->take($nums)->get();
    	}
    	return view('item',compact('list'));
    }
    public function getStartAndEndDateMonth($month, $year){
        $return[0]=date('Y-m-d',  strtotime("first day of last month")); 
        $return[1]=date('Y-m-t',  strtotime("last day of last month")); 
        return $return;
     }
    public function getHotProduct($index,$nums){
        $month= date("m");
        $week=date('W');
        $year=date('Y');
        if($week>0){
            $week--;
        }else{
            $week=52;
            $year--;
        }
        if($month>0){
            $month--;
        }else {
            $month=12;
            $year--;
        }
       	$day= $this->getStartAndEndDateMonth($month,$year);

        $arr= Post::whereBetween('created_at',$day)->get(['id','views']);
        foreach ($arr as $key => $e) {
        	$like=UserLike::where('post_id',$e->id)->groupBy('post_id')->count();
        	$e->views+=$like;
        }
        $arr=$arr->sortByDesc('views')->toArray('id');
        $arr=array_slice($arr,$index,$nums);
        foreach ($arr as $key => $e) {
        	$arr[$key]=Post::find($e['id']);
        }
		return $arr;
    }
    public function getDetail($id){
    	$post=Post::find($id);
        $post->views++;
        $post->save();
    	return view('detail_image',['post'=>$post]);
    }
    
    public function getComment($idPost,$index,$nums,$idComment=null){
        if($idComment==null){
            $comments=UserComment::where('post_id',$idPost)->where('index',1)->orderBy('created_at','DESC')->skip($index)->take($nums)->get();
            if(count($comments)==0) return -1;
            return view('comment',compact('comments'));
        }
        else{
            $comments=UserComment::find($idComment)->subComments($index,$nums);
            if(count($comments)==0) return -1;
            return view('subComment',compact('comments'));
        }
        
    }

    //admin
    public function index(){
        $now = Carbon::now()->addHours(7);
        $now_month = $now->month;
        $now_year = $now->year;

        $listPosts = array();
        $listInter = array();
        
        // thang now_month
        $time1 = Carbon::create($now_year, $now_month, 1, 0,0,0);
        $view1 = DB::table('post')->whereBetween('created_at', array($time1, Carbon::now()))->sum('views');
        $like1 = DB::table('user_like')->whereBetween('created_at', array($time1, Carbon::now()))->count();
        $comment1 = DB::table('users_comments')->whereBetween('created_at', array($time1, Carbon::now()))->count();
        
        $t11 = Carbon::create($now_year-1, $now_month, 1, 0,0,0);
        $t12 = Carbon::create($now_year-1, $now_month, 30, 23,59,59);
        $deposit1 = DB::table('post')->whereBetween('created_at', array($time1, Carbon::now()))->count();
        $deposit11 = DB::table('post')->whereBetween('created_at', array($t11, $t12))->count();

        //thang now_monnth-1
        if($now_month-1 > 0){
            $t2 = Carbon::create($now_year, $now_month-1, 1, 0,0,0);
            $t22 = Carbon::create($now_year, $now_month-1, 30, 23,59,59);
            $t221 = Carbon::create($now_year-1, $now_month-1, 1, 0,0,0);
            $t222 = Carbon::create($now_year-1, $now_month-1, 30, 23,59,59);
        }
        else{
            $t2 = Carbon::create($now_year-1, $now_month+11, 1, 0,0,0);
            $t22 = Carbon::create($now_year-1, $now_month+11, 30, 23,59,59);
            $t221 = Carbon::create($now_year-2, $now_month+11, 1, 0,0,0);
            $t222 = Carbon::create($now_year-2, $now_month+11, 30, 23,59,59);
        }
        
        $view2 = DB::table('post')->whereBetween('created_at', array($t2, $t22))->sum('views');
        $like2 = DB::table('user_like')->whereBetween('created_at', array($t2, $t22))->count();
        $comment2 = DB::table('users_comments')->whereBetween('created_at', array($t2, $t22))->count();
        $deposit2 = DB::table('post')->whereBetween('created_at', array($t2, $t22))->count();
        $deposit22 = DB::table('post')->whereBetween('created_at', array($t221, $t222))->count();


        //thang now_monnth-2
        if($now_month-2 > 0){
            $t3 = Carbon::create($now_year, $now_month-2, 1, 0,0,0);
            $t33 = Carbon::create($now_year, $now_month-2, 30, 23,59,59);
            $t331 = Carbon::create($now_year-1, $now_month-2, 1, 0,0,0);
            $t332 = Carbon::create($now_year-1, $now_month-2, 30, 23,59,59);
        }
        else{
            $t3 = Carbon::create($now_year-1, $now_month+10, 1, 0,0,0);
            $t33 = Carbon::create($now_year-1, $now_month+10, 30, 23,59,59);
            $t331 = Carbon::create($now_year-2, $now_month+10, 1, 0,0,0);
            $t332 = Carbon::create($now_year-2, $now_month+10, 30, 23,59,59);
        }
        
        $view3 = DB::table('post')->whereBetween('created_at', array($t3, $t33))->sum('views');
        $like3 = DB::table('user_like')->whereBetween('created_at', array($t3, $t33))->count();
        $comment3 = DB::table('users_comments')->whereBetween('created_at', array($t3, $t33))->count();
        $deposit3 = DB::table('post')->whereBetween('created_at', array($t3, $t33))->count();
        $deposit33 = DB::table('post')->whereBetween('created_at', array($t331, $t332))->count();
        
        //thang now_monnth-3
        if($now_month-3 > 0){
            $t4 = Carbon::create($now_year, $now_month-3, 1, 0,0,0);
            $t44 = Carbon::create($now_year, $now_month-3, 30, 23,59,59);
            $t441 = Carbon::create($now_year-1, $now_month-3, 1, 0,0,0);
            $t442 = Carbon::create($now_year-1, $now_month-3, 30, 23,59,59);

        }
        else{
            $t4 = Carbon::create($now_year-1, $now_month+9, 1, 0,0,0);
            $t44 = Carbon::create($now_year-1, $now_month+9, 30, 23,59,59);
            $t441 = Carbon::create($now_year-2, $now_month+9, 1, 0,0,0);
            $t442 = Carbon::create($now_year-2, $now_month+9, 30, 23,59,59);
        }
        
        $view4 = DB::table('post')->whereBetween('created_at', array($t4, $t44))->sum('views');
        $like4 = DB::table('user_like')->whereBetween('created_at', array($t4, $t44))->count();
        $comment4 = DB::table('users_comments')->whereBetween('created_at', array($t4, $t44))->count();
        $deposit4 = DB::table('post')->whereBetween('created_at', array($t4, $t44))->count();
        $deposit44 = DB::table('post')->whereBetween('created_at', array($t441, $t442))->count();
        

        //thang now_monnth-4
        if($now_month-4 > 0){
            $t5 = Carbon::create($now_year, $now_month-4, 1, 0,0,0);
            $t55 = Carbon::create($now_year, $now_month-4, 30, 23,59,59);
            $t551 = Carbon::create($now_year-1, $now_month-4, 1, 0,0,0);
            $t552 = Carbon::create($now_year-1, $now_month-4, 30, 23,59,59);

        }
        else{
            $t5 = Carbon::create($now_year-1, $now_month+8, 1, 0,0,0);
            $t55 = Carbon::create($now_year-1, $now_month+8, 30, 23,59,59);
            $t551 = Carbon::create($now_year-2, $now_month+8, 1, 0,0,0);
            $t552 = Carbon::create($now_year-2, $now_month+8, 30, 23,59,59);
        }
        
        //$view5 = DB::table('post')->whereBetween('created_at', array($t5, $t55))->sum('views');
        //$like5 = DB::table('user_like')->whereBetween('created_at', array($t5, $t55))->count();
        $deposit5 = DB::table('post')->whereBetween('created_at', array($t5, $t55))->count();
        $deposit55 = DB::table('post')->whereBetween('created_at', array($t551, $t552))->count();
        
        //array_push($listInter,array('y' => $now_month-4,'a' => $view5, 'b' => $like5));
        array_push($listInter,array('y' => $t4->month,'a' => $view4, 'b'=>$like4, 'c'=>$comment4 ));
        array_push($listInter,array('y' => $t3->month,'a' => $view3, 'b'=>$like3, 'c'=>$comment3 ));
        array_push($listInter,array('y' => $t2->month,'a' => $view2, 'b'=>$like2, 'c'=>$comment2 ));
        array_push($listInter,array('y' => $now_month,'a' => $view1, 'b'=>$like1, 'c'=>$comment1 ));

        array_push($listPosts,array('y' => $t5->year.'-'.$t5->month,'a' => $deposit55,'b' =>$deposit5 ));
        array_push($listPosts,array('y' => $t4->year.'-'.$t4->month,'a' => $deposit44,'b' => $deposit4));
        array_push($listPosts,array('y' => $t3->year.'-'.$t3->month,'a' => $deposit33,'b' => $deposit3 ));
        array_push($listPosts,array('y' => $t2->year.'-'.$t2->month,'a' => $deposit22,'b' => $deposit2));
        array_push($listPosts,array('y' => $time1->year.'-'.$time1->month,'a' => $deposit11,'b' => $deposit1 ));
        
        
        return view('admin.home', ['listPosts'=>$listPosts, 'listInter' => $listInter]);
    }


    public function formatNumber($number){
        if($number > 1000){
            return number_format($number/1000, 1, '.','');
        }
        return number_format($number);
    }


}
