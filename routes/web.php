<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('index_client');
});

Route::get('/account', function () {
    return view('header');
});

Route::group(['middleware' => 'web'], function () {
	Route::get('/home',['as' => 'home','uses'=>'HomeController@getHome']);
	Route::get('/hot',['as' => 'hot','uses'=>'HomeController@getHot']);
	Route::get('/binhchon',['as' => 'binhchon','uses'=>'HomeController@getBinhChon']);
	Route::get('/haihuoc',['as' => 'haihuoc','uses'=>'HomeController@getHaiHuoc']);
	Route::get('/girl',['as' => 'girl','uses'=>'HomeController@getGirlXinh']);
	Route::get('/khac',['as' => 'khac','uses'=>'HomeController@getKhac']);

	Route::get('/loginFb/{id}/{name}/{email}',['as'=>'loginFb','uses'=>'HomeController@checkLoginFb']);
	Route::get('/logout',['as'=>'logout','uses'=>'HomeController@logout']);

	Route::get('/loadItem/{type}/{index}/{nums}','HomeController@loadMoreItem');

	Route::get('/getType','HomeController@getType');

	Route::get('/photos/detail/{id}','HomeController@getDetail');

	Route::get('getComment/{idPost}/{index}/{nums}/{idComment?}','HomeController@getComment');


	//admin
	Route::get('/signin-admin', function(){
            return view('admin.login');
        });
    Route::post('/signin-admin' , 'AdminController@postSignin');

    

});
Route::group(['middleware' => 'user'],function(){
	Route::post('/postImage',['as'=>'post','uses'=>'UserController@post']);
	Route::get('postComment/{idPost}/{comment}/{idComment?}','UserController@postComment');
	Route::get('postLike/{idPost}','UserController@postLike');
	Route::get('postSave/{idPost}','UserController@postSave');
	Route::get('postLikeComment/{idComment}','UserController@postLikeComment');

	Route::get('home/user',['as'=>'u','uses'=>'UserController@getHome']);
	Route::get('/uloadItem/{type}/{index}/{nums}',['as'=>'ugetItem','uses'=>'UserController@loadMoreItem']);
	Route::get('home/profile',['as'=>'profile','uses'=>'UserController@getProfile']);

	Route::post('home/profile/update',['as'=>'updateProfile','uses'=>'UserController@updateProfile']);
});

Route::group(['middleware' => 'admin'], function () {

        // trang chu

        Route::get('/logout-admin', 'AdminController@logOut');
        Route::get('/home-admin', ['uses' => 'HomeController@index', 'as' => 'home-admin']);

        // bai dang

        Route::get('/quan-ly-danh-muc', ['uses'=>'PostController@categoryIndex', 'as'=>'quanlydanhmuc']);
        Route::post('/quan-ly-danh-muc/them-moi', ['uses'=>'PostController@addCategory', 'as'=>'themmoidanhmuc']);
        Route::post('/quan-ly-danh-muc/cap-nhat/{id}', ['uses'=>'PostController@updateCategory', 'as'=>'capnhatdanhmuc']);

        Route::get('/danh-sach-bai-dang', ['uses' => 'PostController@search', 'as' => 'danhsachbaidang']);
        Route::get('/danh-sach-bai-dang/tim-kiem', ['uses' => 'PostController@searchPost', 'as' => 'timkiembaidang']);
        Route::get('/danh-sach-bai-dang/cap-nhat/{id}', ['uses' => 'PostController@updatePost', 'as' => 'capnhatbaidang']);
        Route::get('/danh-sach-bai-dang/xoa/{id}', ['uses' => 'PostController@deletePost', 'as' => 'xoabaidang']);

        Route::get('/bai-dang-cho-phe-duyet', ['uses' => 'PostController@waitProcess', 'as' => 'chopheduyet']);
        Route::get('/bai-dang-cho-phe-duyet/duyet/{id}', ['uses' => 'PostController@confirmPost', 'as' => 'duyetbaidang']);
        Route::get('/bai-dang-cho-phe-duyet/huy/{id}', ['uses' => 'PostController@cancelPost', 'as' => 'huybaidang']);
        Route::get('/danh-sach-bai-dang/auto', ['uses'=>'PostController@autoComplete', 'as'=>'searchajax_post']);

        Route::get('/dua-len-trang-chu', ['uses'=>'PostController@indexUploadHome', 'as'=>'duyetbaitrangchu']);
        Route::get('/dua-len-trang-chu/cap-nhat', ['uses'=>'PostController@uploadHome', 'as'=>'upload_home']);

        //report
        Route::get('/bao-cao', ['uses'=>'ReportController@index', 'as'=>'report']);
        Route::get('/bao-cao/xac-nhan/{id}', ['uses'=>'ReportController@confirmReport', 'as'=>'confirmreport']);

        //thong ke
        Route::get('/thong-ke', ['uses'=>'PostController@statisticIndex', 'as'=>'thongke']);
        Route::post('/thong-ke', ['uses'=>'PostController@statistic', 'as'=>'thong_ke']);

        // nguoi dung
        Route::get('/nguoi-dung', ['uses'=>'UserController@index', 'as'=>'nguoidung']);
        Route::get('/nguoi-dung/tim-kiem', ['uses'=>'UserController@searchUser', 'as'=>'timkiemnguoidung']);
        Route::get('/nguoi-dung/auto', ['uses'=>'UserController@autoComplete', 'as'=>'searchajax_user']);
        Route::get('/nguoi-dung/khoa-tai-khoan/{id}', ['uses'=>'UserController@lockAccount']);

        // tai khoan admin

        Route::get('/tai-khoan', ['uses'=>'AdminController@indexAccount', 'as'=>'taikhoanadmin']);
        Route::post('tai-khoan/them-moi/{id}', ['uses'=>'AdminController@addAccount']);
        Route::post('tai-khoan/cap-nhat/{id}', ['uses'=>'AdminController@updateAccount']);
        Route::get('tai-khoan/xoa/{id}', ['uses'=>'AdminController@delAccount']);
        Route::post('tai-khoan/phan-quyen/{id}', ['uses'=>'AdminController@distributeRole']);

        
    });

