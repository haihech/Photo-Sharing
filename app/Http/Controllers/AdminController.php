<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use App\Admin;
use App\Quyen;
use App\PhanQuyen;
use DB;

class AdminController extends Controller
{
    
    public function postSignin(Request $request){
    	$admin = Admin::where('id', $request->input('manv'))->first();
    	if($admin){
    		if($admin->password == $request->input('password')){
                $request->session()->put('admin', $admin);
                $roles = DB::table('phanquyen')
                    ->where('admin_id', $admin->id)
                    ->join('quyen', 'phanquyen.quyen_id', '=', 'quyen.id')
                    ->select('quyen.id as role_id', 'quyen.tenquyen as role_name')->get();
                $request->session()->put('role', $roles);
                $str_roles = "";
                foreach ($roles as $value) {
                    $str_roles .= " ".(string)$value->role_id;
                }
                $request->session()->put('str_roles', $str_roles);
                return redirect('home-admin');
    	    }
    	}
    	
        return view('web-bansua-admin.sign-in');
    	
    }

    public function logOut(Request $request){
        $request->session()->forget('str_roles');
        $request->session()->forget('admin');
        $request->session()->forget('role');
        return redirect('signin-admin');
    }

    public function format_Time($time){
        $date=date_create($time);
        return date_format($date,"m");
    }

    
    public function indexAccount(){

        $admins = DB::table('admin')->whereNotIn('admin.id', ['admin'])
                    ->get();
        $manv_them = '';
        if(empty($admins)){
            $manv_them = 'admin-01';
        }
        else{
            $count = count($admins) + 1;
            if($count < 10){
                $manv_them = 'admin-0'.$count;
            }
            else{
                $manv_them = 'admin-'.$count;
            }
        }

        $arr;
        $roles = DB::table('quyen')->get();
        $STT = 1;
        
        foreach ($admins as $admin) {
            $role = DB::table('phanquyen')->where('admin_id', $admin->id)->get();
            $str_roles = "";
            foreach ($role as $value) {
                $str_roles .= " ".(string)$value->quyen_id;
            }

            $arr[$STT++] = $str_roles;
            
        }

        return view('admin.taikhoan', ['admins' => $admins, 'manv_them' => $manv_them, 'arr' => $arr, 'roles' => $roles]);
    }

    public function updateAccount($id){
        if(isset($_POST['cap-nhat'])){
            $update = DB::table('admin')->where('admin.id', $id)->update(['password'=>$_POST['password'], 'name'=>$_POST['ht']]);

            return redirect()->route('taikhoanadmin');
        }
    }

    public function addAccount($id){
        if(isset($_POST['them-moi'])){
            $password = $_POST['password_them'];
            $name = $_POST['ht_them'];
            $account = new Admin([
                    'id'=>$id,
                    'password'=>$password,
                    'name'=>$name
                ]);
            $account->save();

            return redirect()->route('taikhoanadmin');
        }
    }

    public function distributeRole($id){
        if(isset($_POST['phanquyen-'.$id])){
            if(isset($_POST['quyen-'.$id])){
                $del = PhanQuyen::where('admin_id', $id)->delete();
                foreach ($_POST['quyen-'.$id] as $value) {
                    $quyen = new PhanQuyen([
                            'quyen_id'=> $value,
                            'admin_id'=>$id
                        ]);
                    $quyen->save();

                }
            }
        }
        
        return redirect()->route('taikhoanadmin');
    }

    public function delAccount($id){
        $del = Admin::where('id',$id)->delete();
        return redirect()->route('taikhoanadmin');
    }

    // public function accountPro(){
    //     return view('web-bansua-admin.account.taikhoan');
    // }


    // public function updateAccountPro(){
    //     if (isset($_POST['cap-nhat'])) {
    //         $manv = Session::get('admin')->manv;
    //         $password = $_POST['password_them'];
    //         $name = $_POST['ht_them'];
    //         $phone = $_POST['sdt_them'];
    //         $cmt = $_POST['cmt_them'];
    //         $addr = $_POST['diachi_them'];
    //         $update = DB::table('nhanvien')->where('manv', $manv)->update(['password'=>$password, 'ten' => $name, 'sdt'=>$phone, 'cmt'=>$cmt, 'diachi'=>$addr]);
            
    //         $nv = NhanVien::where('manv', $manv)->first();
    //         Session::forget('admin');
    //         Session::put('admin', $nv);

    //         return view('web-bansua-admin.account.taikhoan');
    //     }
    // }

}
