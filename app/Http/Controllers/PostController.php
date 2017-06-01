<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests;
use App\Post;
use App\Report;
use Session;
use App\Admin;
use DB;
use Carbon\Carbon;
use App\Notification;

class PostController extends Controller
{

    public function getAllPost(){
        $posts = DB::table('post')->where('post.status', 0)
                ->join('users', 'users.id', '=', 'post.users_id')
                ->join('category', 'category.id', '=', 'post.category_id')
                ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                ->get();
        return $posts;
    }

    public function waitProcess(Request $request){
        
        $posts = $this->getAllPost();
        
    	return view('admin.post.chopheduyet', compact('posts'));
    }

    public function confirmPost($id){
        $update = DB::table('post')->where('id', $id)->update(['post.status'=> 1]);
        $posts = $this->getAllPost();
        
        return view('admin.post.bangchopheduyet', compact('posts'));
    }

    public function cancelPost($id){
        $users_id = Post::where('id', $id)->value('users_id');
        $notification = new Notification([
                'check' => 0,
                'message' => 'Bài đăng mã '.$id.' của bạn đã bị xóa do vi phạm quy định của diễn đàn.',
                'type' => 'Vi phạm',
                'link' => '1',
                'users_id' => $users_id
            ]);
        $notification->save();

        $img_name = Post::where('id',$id)->value('img');
        Storage::Delete('/public/images/' . $img_name);
        $del = Post::where('id',$id)->delete();

        $posts = $this->getAllPost();
        
        return view('admin.post.bangchopheduyet', compact('posts'));
    }

    public function search(){
        $posts = null;
        return view('admin.post.danhsach', ['posts'=>$posts]);
    }

    public function searchPost(Request $request){

        $type = $request->input('selected');
        $search_key = $request->input('post');
        if($search_key == ''){
            if($type == 9){
                $posts = null;
            }
            elseif ($type == 8) {
                // $posts = DB::table('post')->join('users', 'users.id', '=', 'post.users_id')
                //     ->join('category', 'category.id', '=', 'post.category_id')
                //     ->join('user_like', 'user_like.post_id', '=', 'post.id')
                //     ->select('users.nickname as ten', 'category.type as loai', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views', DB::raw('count(user_like.id) as likes'))
                //     ->groupBy('users.nickname', 'category.type', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views')
                //     ->get();
                $posts = DB::table('post')->join('users', 'users.id', '=', 'post.users_id')
                    ->join('category', 'category.id', '=', 'post.category_id')
                    ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                    ->get();

            }
            else{
                if($type == 1){
                    $posts = DB::table('post')->whereIn('post.status', [1,2,3])->join('users', 'users.id', '=', 'post.users_id')
                    ->join('category', 'category.id', '=', 'post.category_id')
                    ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                    ->get();
                }
                else{
                    $posts = DB::table('post')->where('post.status', $type)->join('users', 'users.id', '=', 'post.users_id')
                    ->join('category', 'category.id', '=', 'post.category_id')
                    ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                    ->get();
                }
            }
        }
        else{
            if(strpos($search_key, " - ") !== false){
                $a = explode(' - ', $search_key);
                $posts = DB::table('post')->join('users', 'users.id', '=', 'post.users_id')
                        ->join('category', 'category.id', '=', 'post.category_id')
                        ->where('post.id', 'LIKE', '%'.$a[0].'%')
                        ->where('users.nickname', 'LIKE', '%'.$a[1].'%')
                        ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                        ->orderBy('post.id', 'asc')
                        ->get();
            }
            else{
                $posts = DB::table('post')->join('users', 'users.id', '=', 'post.users_id')
                        ->join('category', 'category.id', '=', 'post.category_id')
                        ->where('post.id', 'LIKE', '%'.$search_key.'%')
                        ->orwhere('users.nickname', 'LIKE', '%'.$search_key.'%')
                        ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                        ->orderBy('post.id', 'asc')
                        ->get();
            }
        }
        

        return view('admin.post.danhsach', ['posts'=>$posts]);
    }

    public function deletePost($id){
        $users_id = Post::where('id', $id)->value('users_id');
        $notification = new Notification([
                'check' => 0,
                'message' => 'Bài đăng mã '.$id.' của bạn đã bị xóa do vi phạm quy định của diễn đàn.',
                'type' => 'Vi phạm',
                'link' => '1',
                'users_id' => $users_id
            ]);
        $notification->save();

        $img_name = Post::where('id',$id)->value('img');
        Storage::Delete('/public/images/' . $img_name);
        $del = Post::where('id',$id)->delete();

        return redirect()->back();
    }

    public function statistic(Request $request){
        $type = $request->input('option_selected_avaiable');
        $month = $request->input('month');
        $day = $request->input('day');
        $year = $request->input('year');
        $now = Carbon::now();

        if($year == 0){
            $listPost = null;
            $listUser = null;
            $listLike = null;
        }
        else{
            if($month == 0){
                $time1 = Carbon::create($year, 1, 1, 0,0,0);
                $time2 = Carbon::create($year, 12, 30, 23,59,59);
            }
            else{
                if($day == 0){
                    $time1 = Carbon::create($year, $month, 1, 0,0,0);
                    $time2 = Carbon::create($year, $month, 30, 23,59,59);
                }
                else{
                    $time1 = Carbon::create($year, $month, $day, 0,0,0);
                    $time2 = Carbon::create($year, $month, $day, 23,59,59);
                }
                
            }
            if($type == 1){
                $listPost = DB::table('post')->whereBetween('post.created_at', array($time1, $time2))
                            ->join('users', 'users.id', '=', 'post.users_id')
                            ->join('category', 'category.id', '=', 'post.category_id')
                            ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                            ->get();
                $listUser = null;
                $listLike = null;
            }
            elseif ($type == 2) {
                $listLike = DB::table('post')->whereBetween('post.created_at', array($time1, $time2))
                        ->join('users', 'users.id', '=', 'post.users_id')
                        ->join('category', 'category.id', '=', 'post.category_id')
                        ->join('user_like', 'user_like.post_id', '=', 'post.id')
                        ->where('user_like.type', 0)
                        ->select('users.nickname as ten', 'category.type as loai', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views', DB::raw('count(user_like.id) as likes'))
                        ->groupBy('users.nickname', 'category.type', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views')
                        ->orderBy('likes', 'desc')
                        ->take(10)
                        ->get();
                $listUser = null;
                $listPost = null;
            }
            elseif ($type == 3) {
                $listUser = DB::table('users')->whereBetween('created_at', array($time1, $time2))->get();
                $listPost = null;
                $listLike = null;
            }
        }

        return view('admin.thongke', ['listPost'=>$listPost, 'listUser'=>$listUser, 'listLike' => $listLike, 'day' => $day, 'month'=>$month, 'year'=>$year]);
    }

    public function statisticIndex(){
        $listPost = null;
        $listLike = null;
        $listUser = null;
        $month = null;
        $year = null;
        $day = null;
        return view('admin.thongke', ['listPost'=>$listPost, 'listUser'=>$listUser, 'listLike' => $listLike, 'day' => $day, 'month'=>$month, 'year'=>$year]);
    }

    public function autoComplete(Request $request) {
        
        $query = $request->get('term');

        $list = DB::table('post')->join('users', 'users.id', '=', 'post.users_id')
                        ->where('post.id', 'LIKE', '%'.$query.'%')
                        ->orwhere('users.nickname', 'LIKE', '%'.$query.'%')
                        ->select('post.id', 'users.nickname')
                        ->orderBy('post.id', 'asc')
                        ->take(6)
                        ->get();
        
        $data=array();
        foreach ($list as $post) {
                $data[]=array('value'=>$post->id.' - '.$post->nickname);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }

    public function indexUploadHome(){
        $posts = DB::table('post')->where('post.status', 1)
                        ->join('users', 'users.id', '=', 'post.users_id')
                        ->join('category', 'category.id', '=', 'post.category_id')
                        ->join('user_like', 'user_like.post_id', '=', 'post.id')
                        ->where('user_like.type', 0)
                        ->select('users.nickname as ten', 'category.type as loai', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views', DB::raw('count(user_like.id) as likes'))
                        ->groupBy('users.nickname', 'category.type', 'post.id', 'post.created_at', 'post.img', 'post.status', 'post.title','post.views')
                        ->orderBy('likes', 'desc')
                        ->take(5)
                        ->get();
        if(count($posts) > 0)
            return view('admin.post.duyetbaitrangchu', ['posts'=>$posts]);
        else
            return view('admin.post.duyetbaitrangchu', ['posts'=>null]);
    }

    public function uploadHome(){
        $posts = DB::table('post')->where('post.status', 1)
                        ->join('users', 'users.id', '=', 'post.users_id')
                        ->join('category', 'category.id', '=', 'post.category_id')
                        ->join('user_like', 'user_like.post_id', '=', 'post.id')
                        ->where('user_like.type', 0)
                        ->select('post.id', DB::raw('count(user_like.id) as likes'))
                        ->groupBy('post.id')
                        ->orderBy('likes', 'desc')
                        ->take(5)
                        ->get();

        foreach ($posts as $value) {
            $update = DB::table('post')->where('id', $value->id)->update(['post.status'=> 2]);
        }
        $now = Carbon::now()->addHours(7);
        $dayBefore = Carbon::now()->addHours(7)->subDay(); 
        $list = DB::table('post')->where('post.status', 1)->whereNotBetween('created_at', array($dayBefore, $now))->update(['post.status'=> 3]);
        return redirect()->back();
    }


    public function categoryIndex(){
        $categorys = DB::table('category')->get();
        return view('admin.post.quanlytieude', ['categorys'=>$categorys]);
    }

    public function updateCategory($id){
        if(isset($_POST['cap-nhat'])){
            $update = DB::table('category')->where('category.id', $id)->update(['category.type'=>$_POST['ht']]);

            return redirect()->route('quanlydanhmuc');
        }
    }

    public function addCategory(){
        if(isset($_POST['them-moi'])){
            $name = $_POST['ht_them'];
            DB::table('category')->insert(
                ['type' => $name]
            );

            return redirect()->route('quanlydanhmuc');
        }
    }
}
