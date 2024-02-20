<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post ;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Auth ;
class PostController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
        // $this->checkRole();
    }
   
    public function index()
    {
           try {  
                
            
            if($this->roleInfo()) {
                 $data =  Post::leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                  ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                
                 ->leftJoin('users' ,'posts.uid' , '=' , 'users.id')
                 ->select('posts.*' , 'categories.category as category_name' ,  'users.name as username', 'sub_categories.subcategory as subcategory_name' )
                  ->orderby('posts.created_at' , 'desc')->get();
            } else {
                $uid =  auth()->user()->id ;
                $data =  Post::where('posts.uid' , $uid )
                ->whereNotIn('posts.status', ['deleted'])
                ->leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                ->select('posts.*' , 'categories.category as category_name' ,'sub_categories.subcategory as subcategory_name' )
                ->orderby('posts.created_at' , 'desc')->get();
            }
            $type =  'blog';

             return view('admin.blog.index' , compact('data' , 'type'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

    public function getPending()
    {
           try {  
            if($this->roleInfo()) {
                 $data =  Post::where('posts.status' , 'pending')->leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                  ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                 ->leftJoin('users' ,'posts.uid' , '=' , 'users.id')
                 ->select('posts.*' , 'categories.category as category_name' ,  'users.name as username' ,'sub_categories.subcategory as subcategory_name' )
                  ->orderby('posts.created_at' , 'desc')->get();
            } 

            $type =  'pending';
             return view('admin.blog.index' , compact('data' , 'type'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

    public function getDeleted()
    {
           try {  
            if($this->roleInfo()) {
                 $data =  Post::where('posts.status' , 'deleted')->leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                  ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                 ->leftJoin('users' ,'posts.uid' , '=' , 'users.id')
                 ->select('posts.*' , 'categories.category as category_name' , 'users.name as username'  , 'sub_categories.subcategory as subcategory_name' )
                  ->orderby('posts.created_at' , 'desc')->get();
            } 
            $type =  'deleted';
             return view('admin.blog.index' , compact('data' , 'type'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }
   
    public function create()
    {
         try {
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            // dd($category);
            return view('admin.blog.create' , compact('category'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }

       
       
    }

   
    public function store(Request $request)
    {
         
             //   dd($request->all());
          try {
             $validator = Validator::make($request->all(), [
              'category' => 'required|numeric',
              'subcategory' => 'required|numeric',
              'title'  => 'required|string',
              'banner' => 'required|image|mimes:jpeg,png,jpg,svg|max:500',    
                'long_description' => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seo   =   $this->seoName($request->title);
            if( !empty($seo)){
             
              $seoCheck =   Post::where('title_seo' , $seo)->first();
              if( !empty($seoCheck)){
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
        
            }
            DB::beginTransaction();
            $data                          =    new Post;
            $data->category                =  $request->category;
            $data->subcategory             =  $request->subcategory;
            $data->title                   =  $request->title;
            $data->title_seo               =  $seo;
            
            $data->long_description        =  $request->long_description;
    
            $data->uid                     =  Auth::user()->id;
            $data->status                  =  'pending';
            $data->view                    =   0;
         
            if (!empty($request->banner)) {
              $value = $request->banner;
              $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
              $extension = $value->getClientOriginalExtension();
              if (in_array($extension, $allowedExtensions)) {
                  $banner = md5(time()) . '.' . $extension;
                  $value->move(public_path() . '/data/post/', $banner);
                  $data->post_banner = $banner;
              } else {
                  return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
              }
            }
    
            $data->save();
            DB::commit();
            return redirect('/admin/blog')->with('success' , 'data update successfully');
          } catch( \Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error' , 'Error found in url ! '.$e->getMessage());
          }
        
    }
   
    public function show(string $id)
    {
        //
    }

  
    public function edit(Request $request)
    {
        try {
            $id =  Crypt::decrypt($request->id);
            $data = Post::find($id);
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            $subcategory =  DB::table('sub_categories')->where('category' , $data->category)->orderby('subcategory' , 'asc')->get();

            return view('admin.blog.edit' , compact('data' , 'category' , 'subcategory'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }

    
    public function update(Request $request)
    {
            
      try {
          $validator = Validator::make($request->all(), [
              'category' => 'required|numeric',
              'subcategory' => 'required|numeric',
              'title'  => 'required|string',
              
              'long_description' => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id    = Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->title);
        $data  =  Post::find($id);
        if( !empty($seo)){
          
          $seoCheck =   Post::where('title_seo' , $seo)->first();
          if( !empty($seoCheck)){
           
            if($data->id  !== $seoCheck->id) {
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
            }
        }
        DB::beginTransaction();
        
        $data->category                =  $request->category;
        $data->subcategory             =  $request->subcategory;
        $data->title                   =  $request->title;
        $data->title_seo               =  $seo;
        
        $data->long_description        =  $request->long_description;

        if($this->roleInfo()){
          $data->status                   =  $request->status;
        } else {
          $data->status                   =  'pending';
        }
       

     
        if (!empty($request->banner)) {
          $value = $request->banner;
          $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
          $extension = $value->getClientOriginalExtension();
          if (in_array($extension, $allowedExtensions)) {
                $filePath =  public_path().'/data/post/'.$data->post_banner;

             if (file_exists($filePath)) {

                 unlink($filePath);
             
              }
              $banner = md5(time()) . '.' . $extension;
              $value->move(public_path() . '/data/post/', $banner);
              $data->post_banner = $banner;
          } else {
              return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
          }
        }

        $data->update();
        DB::commit();
        return redirect('/admin/blog')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
         try {
            $id =  Crypt::decrypt($request->id);
            $data = Post::find($id);
            if (!$data) {
              return redirect()->back()->with('error' , 'Error found in url !');
            }
            $filePath =  public_path().'/data/post/'.$data->post_banner;

             if (file_exists($filePath)) {

                 unlink($filePath);
              
               }
            $data->status = 'deleted';
            $data->update();
            return redirect('/admin/blog')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

