<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Input;
use App\Post;
use Auth;
use App\UserSave;
use App\UserLike;
use App\UserComment;
use App\UserSubComment;
use App\UserLikeComment;
use App\Category;
use Session;
use Hash;
use Validator;
use DB;

class UserController extends Controller
{
    public function getHome(){
        return view('user_home');
    }
    public function getProfile(){
        return view('profile');
    }
    public function updateProfile(){
        if(Input::file('avatar')!=null){
            $destinationPath = 'images';
            $extension = Input::file('avatar')->getClientOriginalExtension();
            $fileName =Auth::user()->id_fb.'.'.$extension;
            Input::file('avatar')->move($destinationPath, $fileName);
        }
        Auth::user()->nickname=Input::get('nickname');
        if(Input::has('username')&&Input::has('password')&&Input::has('password_confirmation')){//tao tk
            $u=str_replace(' ','',Input::get('username'));
            $validator = $this->validator(['username'=>$u,'password'=>Input::get('password'),'password_confirmation'=>Input::get('password_confirmation')]);
            if ($validator->fails()){
                $errors = ($validator->errors()->getMessages());
                return redirect()->back()->with('failUpdate','Cập nhật không thành công!');
            }
            Auth::user()->username=$u;
            Auth::user()->password=Hash::make(str_replace(' ','',Input::get('password')));
        }else
        if(Input::has('password')&&Input::has('password_confirmation')){
            if (Hash::check(Input::get('oldPassword'), Auth::user()->password)){
                if(Input::get('password')==Input::get('password_confirmation')){
                    Auth::user()->password=Hash::make(str_replace(' ','',Input::get('password')));
                }else{
                    return redirect()->back()->with('FailUpdate','Nhập lại mật khẩu không khớp!');
                }
            }else{
                return redirect()->back()->with('FailUpdate','Mật khẩu không đúng!');
            }
        }
        Auth::user()->save();
        return redirect()->back()->with('failUpdate','Cập nhật thành công!');
    }
    public function loadMoreItem($type=2,$index,$nums){
        $list=Post::where('users_id',Auth::user()->id)->where('status',$type)->skip($index)->take($nums)->get();
        return view('item',compact('list'));
    }
    
    protected function validator(array $data) {
        return Validator::make($data, [
            'username' => 'unique:users,username',
            'password' => 'confirmed',
            'password_confirmation' => 'required',
        ]);
    }

    public function post(Request $request){
    	if (Input::file('img')!=null&&Input::get('type')!=null&&Input::get('title')!=null){
    		  $destinationPath = 'images'; // upload path
		      $extension = Input::file('img')->getClientOriginalExtension();
		      $count=Post::where('users_id',Auth::user()->id)->get()->count()+1;
		      $fileName = Date('Ymd').'_'.$count.'_'.Auth::user()->id.'.'.$extension; // renameing image
		      Input::file('img')->move($destinationPath, $fileName); // uploading file to given path
		      $category_id=Category::where('type',Input::get('type'))->first()->id;

		      $post=Post::create([
		      	'users_id'=>Auth::user()->id,
		      	'title'=>Input::get('title'),
		      	'views'=>0,
		      	'img'=>$fileName,
		      	'status'=>0,
		      	'category_id'=>$category_id,
		      	]);
		      $post->save();
		      // sending back with message
		      Session::flash('post', 'success'); 
    	}else{
    		Session::flash('post', 'fail'); 
    	}
    	return redirect()->back();
    }
    public function postComment($idPost,$comment,$idComment=null){
        $index=1;
        if($idComment!=null) $index=2;
        $c=UserComment::create([
            'comment'=>$comment,
            'index'=>$index,
            'users_id'=>Auth::user()->id,
            'post_id'=>$idPost
        ]);
        $c->save();
        $view='comment';
        if($index==2){
            UserSubComment::create([
                'users_comments_id'=>$idComment,
                'users_subcomments_id'=>$c->id,
            ])->save();
            $view='subComment';
        }
        $comments[]=$c;
        return view($view,compact('comments'));
    }
    public function postLike($idPost){
        $like=UserLike::where('users_id',Auth::user()->id)->where('post_id',$idPost)->first();
        if($like==null){
            UserLike::create([
                'users_id'=>Auth::user()->id,
                'post_id'=>$idPost
            ])->save();
        }else{
            $like->delete();
        }
    }
    public function postSave($idPost){
        $like=UserSave::where('users_id',Auth::user()->id)->where('post_id',$idPost)->first();
        if($like==null){
            UserSave::create([
                'users_id'=>Auth::user()->id,
                'post_id'=>$idPost
            ])->save();
        }else{
            $like->delete();
        }
    }
    public function postLikeComment($idComment){
        $like=UserLikeComment::where('users_id',Auth::user()->id)->where('users_comments_id',$idComment)->first();
        if($like==null){
            UserLikeComment::create([
                'users_id'=>Auth::user()->id,
                'users_comments_id'=>$idComment
            ])->save();
        }else{
            $like->delete();
        }
    }

    //admin
    //admin
    public function autoComplete(Request $request) {
        $query = $request->get('term');

        $listUser = DB::table('users')->where('users.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.username', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.nickname', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.email', 'LIKE', '%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->take(6)
                    ->get();
        
        $data=array();
        foreach ($listUser as $user) {
                $data[]=array('value'=>$user->username);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'Không tìm thấy'];
    }
    public function index(){
        $listUser = null;
        return view('admin.nguoidung', ['listUser'=>$listUser]);
    }

    public function searchUser(Request $request){
        $query = $request->input('user');
        $listUser = DB::table('users')->where('users.id', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.username', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.nickname', 'LIKE', '%'.$query.'%')
                    ->orwhere('users.email', 'LIKE', '%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->get();

        if(count($listUser) > 0){
            return view('admin.nguoidung', ['listUser'=>$listUser]);
        }
        else{
            $list = null;
            return view('admin.nguoidung', ['listUser'=>$list]);
        }
    }

    public function lockAccount($id){
        $lock = User::where('id', $id)->update(['status' => 0]);
        return redirect()->back();
    }
}
