<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Cart;
use Datatables;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Crypt;

class ManageController extends Controller
{
    public function register()
    {
    	return view('news.user.register');
    }
	//
    public function postAdd(Request $request)
    {
    	if($request->ajax()){
			$user = Admin::where('username' , '=', $request->input('username'))->get();
			if(count($user) > 0) {
				return 'Tài khoản đã tồn tại';
			}else {
				$author = new Admin();
				$author->name = $request->input('name');
                $author->username = $request->input('username');
                $author->password =bcrypt($request->input('password'));
                $author->tid = 1;
                $author->status = 1;
				$author->created = time();			
				$author->save();
				Session::flash('register_success','Tài khoản đã được tạo thành công vui lòng đăng nhập để sử dụng');
				return 'ok';
			}
	    }
    }

    public function postLogin(Request $request)
    {
    	$rules = [
    		'username' => 'required',
    		'password' => 'required'
    	];

    	$msg = [
		    'username.required' => 'Tên đăng nhập không được bỏ trống.',
		    'password.required' => 'Mật khẩu không được bỏ trống.',
		];
	
    	$validator = Validator::make($request->all(), $rules , $msg);

    	if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        } else {
        	// $username = $request->input('username');
        	// $password = $request->input('password');
        	
        	// if( Auth::attempt(['username' => $username, 'password' => $password, 'tid'=> 4]) ){
        	// 	return redirect()->route('dashbroad');
        	// } else {
        	// 	$msg = new MessageBag(['errlogin'=> 'Sai thông tin đăng nhập.']);
        	// 	return redirect()->back()->withErrors($msg);
        	// }
        }
    }
    
    public function getLogout()
    {
        if( Auth::check() ) Auth::logout();
        return redirect()->route('login');
	}
	
	public function getProfile()
    {
    	//$profile = Admin::find(Auth::user()->id);
    	return view('news.user.profile');
	}
	public function profileUpdate(Request $request)
    {
        // if($request->input('name') == Auth::user()->name && $request->input('email') != Auth::user()->email ){
        //     $rules= [
        //         'name'=>'required|min:3|max:100',
        //         'password' =>'required|min:4 | max:100',
        //         'email'=> 'required| email |unique:admin,email',
        //         'birthday'=> ' date',
        //         ];
        // } else if($request->input('email') == Auth::user()->email && $request->input('name') != Auth::user()->name){
        //     $rules= [
        //         'name'=>'required|min:3|max:100|unique:admin,name',
        //         'password' =>'required|min:4|max:100',
        //         'email'=> 'required|email',
        //         'birthday'=> 'date',
        //         ];
        // } else if ($request->input('name') == Auth::user()->name && $request->input('email') == Auth::user()->email ) {
        //     $rules= [
        //         'name'=>'required|min:3|max:100',
        //         'password' =>'required|min:4|max:100',
        //         'email'=> 'required|email',
        //         'birthday'=> 'date',
        //     ];
        // } else {
        //     $rules= [
        //         'name'=>'required|min:3|max:100|unique:admin,name',
        //         'password' =>'required|min:4 | max:100',
        //         'email'=> 'required| email | unique:admin,email',
        //         'birthday'=> 'date',
        //         ];
        // }
    	
    	// $msg = [
    	// 		'required'=>'Không được bỏ trống :attribute.',
    	// 		'name.unique' => 'Tên này đã bị trùng, vui lòng nhập lại!',
    	// 		'name.min'=>'Tên gồm ít nhất 3 ký tự!',
    	// 		'name.max'=>'Tên gồm tối đa 100 ký tự!',
    	// 		'password.min'=>'Password gồm ít nhất 4 ký tự!',
    	// 		'password.max'=>'Password gồm tối đa 100 ký tự!',
    	// 		'email'=>'Email không chính xác.',
    	// 		'email.unique'=> 'Email đã tồn tại.',
    	// 		'birthday.date' => 'Sai định dạng ngày!',
    	// 		];
		// $validator = Validator::make($request->all(), $rules , $msg);

		// if ($validator->fails()) {
		//     return redirect()->back()
		//                 ->withErrors($validator)
		//                 ->withInput();
		// } else {
		// 	$profile = Admin::find(Auth::user()->id);
		// 	$profile->name = $request->input('name');
	    // 	$profile->email = $request->input('email');
	    // 	$profile->birthday = $request->input('birthday');
	    // 	$profile->password= bcrypt($request->input('password'));
        //     //Upload Image
        //     if($request->hasFile('avatar')){
        //         $file = $request->file('avatar');
        //         $file_extension = $file->getClientOriginalExtension(); // Lấy đuôi của file
        //         if($file_extension != 'png' && $file_extension != 'jpg' && $file_extension != 'jpeg'){
        //             return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.');
        //         }
        //         $file_name = $file->getClientOriginalName();
        //         $random_file_name = str_random(4).'_'.$file_name;
        //         while(file_exists('upload/profiles/'.$random_file_name)){
        //             $random_file_name = str_random(4).'_'.$file_name;
        //         }
        //         $file->move('upload/profile',$random_file_name);
        //         $file_upload = 'upload/profile/'.$random_file_name;
        //         $profile->avatar = $file_upload;
        //     } else $profile->avatar = '';
            
        //     $profile->save();
	    // 	Session::flash('flash_success','Thay đổi thành công.');
    	// 	return redirect()->back();
		// }
    }
    //borow book
    public function borow_book($id)
    {
    	$item = DB::table('products')->find($id);
    	return view('news.user.borow', ['item' => $item]);
    }

    public function add_cart(Request $request)
    {
        if($request->input('id') > 0) {
            $cart = new Cart();
            $cart->users_id = 12;
            $cart->products_id = $request->input('id');
            $cart->status = 0;
            $cart->date = $request->input('date');
            $cart->qty = $request->input('qty');
            $cart->created = time();
            $cart->save();
        }           
    	Session::flash('flash_success','Mượn sách thành công.');
    	//return redirect()->route('user.borow_book');
    }
}
