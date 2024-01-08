<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Post ;
use App\Models\ViralPost ;
use Crypt ;
use DB ;
use Auth ;
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
            $data =  Post::leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
            ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
            ->leftJoin('topics' ,'posts.topic' , '=' , 'topics.id')
            ->select('posts.*' , 'categories.category as category_name' , 'sub_categories.subcategory as subcategory_name' , 'topics.topic as topic_name')
            ->orderby('posts.created_at' , 'desc')->get();

             return view('admin.blog.index' , compact('data'));
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
         
                
          try {
             $validator = Validator::make($request->all(), [
              'category' => 'required|numeric',
              'subcategory' => 'required|numeric',
              'topic'  => 'required|numeric',
              'title'  => 'required|string',
                'sort_description'  => 'required|string',
                'long_description' => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seo   =   $this->seoName($request->title);
            if( !empty($seo)){
              $seoCheck1 = ViralPost::where('title_seo' , $seo)->first();
              $seoCheck2 =   Post::where('title_seo' , $seo)->first();
              if(! empty($seoCheck1) || !empty($seoCheck2)){
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
        
            }
            DB::beginTransaction();
            $data                          =    new Post;
            $data->category                =  $request->category;
            $data->subcategory             =  $request->subcategory;
            $data->topic                   =  $request->topic;
            $data->title                   =  $request->title;
            $data->title_seo               =  $seo;
            $data->sort_description        =  $request->sort_description;
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
            return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
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
            $topic =  DB::table('topics')->where('subcategory' , $data->subcategory)->orderby('topic' , 'asc')->get();

            return view('admin.blog.edit' , compact('data' , 'category' , 'subcategory' ,'topic'));
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
              'topic'  => 'required|numeric',
              'title'  => 'required|string',
              'sort_description'  => 'required|string',
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
          $seoCheck1 = ViralPost::where('title_seo' , $seo)->first();
          $seoCheck2 =   Post::where('title_seo' , $seo)->first();
          if(! empty($seoCheck1) || !empty($seoCheck2)){
           
            if($data->id  !== $seoCheck2->id) {
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
            }
        }
        DB::beginTransaction();
        
        $data->category                =  $request->category;
        $data->subcategory             =  $request->subcategory;
        $data->topic                   =  $request->topic;
        $data->title                   =  $request->title;
        $data->title_seo               =  $seo;
        $data->sort_description        =  $request->sort_description;
        $data->long_description        =  $request->long_description;
       

     
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
            $data->delete();
            return redirect('/admin/blog')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

