<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;
use App\File;
use Auth;
use Validator;
use Session;

class PostController extends Controller
{
    public function getList()
    {
        $posts = Post::all();

        if(Auth::user()->role=='author'){
            $posts = $posts->where('user_id',Auth::user()->id);
        }
    	return view('admin.post.list',['posts'=>$posts]);
    }
    public function getAdd()
    {
    	$cates = Category::all();
    	$tags = Tag::all();
    	return view('admin.post.add',['cates'=>$cates,'tags'=>$tags]);
    }
    public function postAdd(Request $request)
    {
    	$rules= [
    			'vn_name'=>'required',
    			];
    	$msg = [
    			'vn_name.required'=>'Không được bỏ trống tên sách.',
    			];
		$validator = Validator::make($request->all(), $rules , $msg);

		if ($validator->fails()) {
		    return redirect()->back()
		                ->withErrors($validator)
		                ->withInput();
		} else {
	    	$post = new Post();
	    	$post->vn_name = $request->input('vn_name');
	    	$post->status = $request->input('status');
	    	// //Upload Image
	    	// if($request->hasFile('img_post')){
	    	// 	$file = $request->file('img_post');
	    	// 	$file_extension = $file->getClientOriginalExtension(); // Lấy đuôi của file
	    	// 	if($file_extension == 'png' || $file_extension == 'jpg' || $file_extension == 'jpeg'){
	    	// 		$post->post_type = 'text';
	    	// 	} else if($file_extension == 'mp4' || $file_extension == '3gp' || $file_extension == 'avi' || $file_extension == 'flv'){
	    	// 		$post->post_type = 'video';
	    	// 	} else return redirect()->back()->with('errfile','Chưa hỗ trợ định dạng file vừa upload.')->withInput();

	    	// 	$file_name = $file->getClientOriginalName();
	    	// 	$random_file_name = str_random(4).'_'.$file_name;
	    	// 	while(file_exists('upload/posts/'.$random_file_name)){
	    	// 		$random_file_name = str_random(4).'_'.$file_name;
	    	// 	}
	    	// 	$file->move('upload/posts',$random_file_name);
	    	// 	// $file_upload = new File();
	    	// 	// $file_upload->name = $random_file_name;
	    	// 	// $file_upload->link = 'upload/posts/'.$random_file_name;
	    	// 	// $file_upload->post_id = $post->id;
	    	// 	// $file_upload->save();
	    	// 	$post->feture = 'upload/posts/'.$random_file_name;
	    	// } else $post->feture='';
	    	$post->save();
    	}
    	Session::flash('flash_success','Thêm tin tức thành công.');
    	return redirect()->route('list-post');
    }
    public function getUpdate($id)
    {
    	$post = Post::find($id);
        if($post){
            return view('admin.post.edit',['post'=>$post]);
        }
    	else {
            Session::flash('flash_err','Sai Thông tin Bài Viết.');
            return redirect()->route('list-post');
        }
    	
    }

    public function postUpdate(Request $request,$id)
    {
    	$post = Post::find($id);
        if( $post ) {
            $rules= [
                    'vn_name'=>'required',
                    ];
            $msg = [
                    'vn_name.required'=>'Không được bỏ trống tên sách.',
                    ];

            $validator = Validator::make($request->all(), $rules , $msg);

            if ($validator->fails()) {
                return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
            } else {
                $post->vn_name = $request->input('vn_name');
                $post->status = $request->input('status');
                $post->save();
                Session::flash('flash_success','Thay đổi thành công.');
                return redirect()->route('list-post');
            }
        } else {
            Session::flash('flash_err','Sai thông tin bài viết.');
            return redirect()->route('list-post');
        }
    }
    	
    public function getDelete($id)
    {
    	$post = Post::find($id);
	    	if( $post ){
                $post->delete();
                Session::flash('flash_success','Xóa thành công.');
	    	} else {
	    		Session::flash('flash_err','Bài viết không tồn tại.');
	    	}
	    	return redirect()->route('list-post');
    }
    public function updateStatus(Request $request)
    {
        if($request->ajax()){
            $post = Post::find($request->input('id'));
            if( $post ){
                if($request->input('status') == 0 || $request->input('status') == 1 ){
                    $post->status = $request->input('status');
                    $post->save();
                    return 'ok';
                } else { 
                    return 'Sai trạng thái.';
                }
            } else { 
                return 'Bài viết không tồn tại.'; 
            }
        }
    }
}
