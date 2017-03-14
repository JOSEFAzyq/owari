<?php

namespace App\Http\Controllers;


use App\Http\Models\Admin;
use App\Http\Models\Article;
use App\Http\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

	private $salt=null;

	public function __construct()
	{
		$this->salt='josefa';
		\DB::enableQueryLog();
	}

    //登录
	public function login()
	{
		return view('admin.login');
	}

	//登出
	public function logOut()
	{
		session()->flush();
		return redirect('admin/login');
	}


	public function checkLogin()
	{
		$user_name=Input::get('user_name');
		$password=Input::get('password');
		$str=md5($password.$this->salt);
		Log::info('user try to login admin,info=>'.json_encode(Input::get()));
		if($userInfo=Admin::where(['user_name'=>$user_name,'password'=>$str])->first()){
			session(['user_name'=>$user_name]);
			session(['password'=>$str]);
			return redirect('admin/index');
		}else{
			return redirect('admin/login');
		}
	}

	public function index()
	{
		return view('admin.index');
	}

	/*
	 * 文章发布
	 * */
	public function articlePublish()
	{
		return view('admin.articlePublish');
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

		factory(Article::class,'article')->create();
		/*$articles=Article::all();
		foreach ($articles as $article){
			echo $article->title;
		}*/

		/*$article=Article::where('id',7)->first();
		var_dump($article);*/

		/*$article=Article::where('id','<',15)->get();
		var_dump($article);*/

		Admin::test();
	}
}
