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

class ReportController extends Controller
{

    public function index(Request $request){
        
        $posts = DB::table('post')
                ->join('report', 'report.post_id', '=', 'post.id')
                ->where('report.status', 0)
                ->join('users', 'users.id', '=', 'post.users_id')
                ->select('users.nickname as ten', 'post.id','post.created_at','post.img','post.title', 'post.views', DB::raw('count(report.id) as total_report'))
                ->groupBy('users.nickname', 'post.id','post.created_at','post.img','post.title','post.views')
                ->havingRaw('count(report.id) > 0')
                ->get();
        $arr = array();
        $stt = 1;
        foreach ($posts as $value) {
            $report = DB::table('report')->where('report.post_id', $value->id)
                      ->where('report.status', 0)
                      ->join('users', 'users.id', '=', 'report.users_id')
                      ->select('users.nickname as ten', 'report.*')
                      ->get();
            $arr[$stt++] = $report;
        }
    	return view('admin.report', ['posts' => $posts,'i' => count($posts), 'arr' => $arr]);
    }

    public function confirmReport($id){
        $update = Report::where('post_id', $id)->update(['report.status'=> 1]);
        return redirect()->route('report');
        
    }

    public function searchPost(Request $request){
        $key = $request->input('selected');
        if($key == 8){
            $posts = DB::table('post')
                ->join('users', 'users.id', '=', 'post.users_id')
                ->join('category', 'category.id', '=', 'post.category_id')
                ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                ->get();
        }
        elseif ($key == 9) {
            $posts = null;
        }
        else{
            $posts = DB::table('post')->where('post.status', $key)
                ->join('users', 'users.id', '=', 'post.users_id')
                ->join('category', 'category.id', '=', 'post.category_id')
                ->select('users.nickname as ten', 'category.type as loai', 'post.*')
                ->get();

        }
        
        return view('admin.post.danhsach', ['posts' => $posts]); 
    }

    public function search(Request $request){
        $posts = null;
        return view('admin.post.danhsach', ['posts' => $posts]);
    }

    public function deletePost($id){
        $post = Post::where('id', $id)->value('img');
        $path = '/public/images/' . $post;
        Storage::delete($path);
        $del = Post::where('id', $id)->delete();

        return redirect()->back();
    }

}
