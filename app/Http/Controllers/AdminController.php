<?php

namespace App\Http\Controllers;


use App\Http\Models\Admin;
use App\Http\Models\Article;
use App\Http\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

	private $salt=null;
	protected $admin;

	public function __construct()
	{
		$this->salt='josefa';
		$this->admin=new Admin();
		//本地自动登录咯
        if(getenv('APP_ENV')=='local'){
            session(['userInfo'=>[
                'id'=>1,
                'user_name'=>'OwaraiClub',
                'password'=>'93a637fb7cd4343af8ca539093aeec5a',
                'bbs_child_id'=>0,
                'fansub_id'=>0,
                'sensitive_auth'=>'',
                'character'=>'super',
                'created_at'=>'2017-03-14 22:00:18',
                'updated_at'=>'2017-03-14 22:00:20'
            ]]);
        }
	}

    //登录
	public function login(Request $request)
	{
		if($this->admin->checkLogin($request)){
			return redirect('admin/index');
		}
		return view('admin.login');
	}

	//登出
	public function logOut()
	{
		session()->forget('userInfo');
		return redirect('admin/login');
	}

    //验证
	public function checkLogin(Request $request)
	{
        Log::info('user try to login admin,info=>'.json_encode(Input::get()));
        $rs=$this->admin->checkLogin($request);
        if ($rs){
            return redirect('admin/index');
        }else{
            return redirect('admin/login');
        }

	}

	public function index()
	{

		return view('admin.index');
	}

	//文章列表
	public function articleList()
	{
		return view('admin.articleList');
	}

	/*
	 * 文章发布
	 * */
	public function articlePublish()
	{
		return view('admin.articlePublish');
	}

	//文章处理
    public function articleHandle()
    {
		$articleData=Input::get();
		foreach ($articleData as $k=>$v){
			if($v=='on'){
				$articleData[$k]=1;
			}
		}
		$articleData['user_id']=1;
		$rs=Article::create($articleData);
		if($rs){
			return redirect('admin/articleList');
		}else{
			return '发布失败咯';
		}
	}



	public function test()
	{

		/*$salt='josefa';
		$password='soragaaoina.';
		$str=md5($password.$salt);
		var_dump($str);*/
		/*factory(Article::class,'article', 50)->create()->each(function($u) {
			$u->posts()->save(factory('App\Post')->make());
		});*/

		/*\DB::table('admin')->insert([
			'name' => str_random(10),
			'email' => str_random(10).'@gmail.com',
			'password' => bcrypt('secret'),
		]);*/
		/*$user=factory(User::class)->create();
		var_dump($user);*/

		/*$admin=new Admin;
		$admin->user_name='test';
		$admin->password='123';
		$admin->save();*/

		//factory(User::class)->create();

		/*factory(Article::class,'article')->create();*/
		/*$articles=Article::all();
		foreach ($articles as $article){
			echo $article->title;
		}*/

		/*$article=Article::where('id',7)->first();
		var_dump($article);*/

		/*$article=Article::where('id','<',15)->get();
		var_dump($article);*/

		/*Admin::test();*/
	}
}
