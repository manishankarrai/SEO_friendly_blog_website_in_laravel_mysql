<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ViralPost ;
use App\Models\Post ;
use Illuminate\Support\Facades\Validator;
use Crypt ;
use DB ;
use Auth ;
class ViralPostController extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
       // $this->checkRole();
    }
   
    public function index()
    {
           try {  
            $data =  ViralPost::leftJoin('categories' ,'viral_posts.category' , '=' , 'categories.id')
            ->leftJoin('sub_categories' ,'viral_posts.subcategory' , '=' , 'sub_categories.id')
            ->leftJoin('topics' ,'viral_posts.topic' , '=' , 'topics.id')
            ->select('viral_posts.*' , 'categories.category as category_name' , 'sub_categories.subcategory as subcategory_name' , 'topics.topic as topic_name')
            ->orderby('viral_posts.created_at' , 'desc')->get();

             return view('admin.viralpost.index' , compact('data'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

   
    public function create()
    {
         try {
             $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            return view('admin.viralpost.create' , compact('category'));
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
              'link'  => 'required|string',
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
            $data                          =  new ViralPost;
            $data->category                =  $request->category;
            $data->subcategory             =  $request->subcategory;
            $data->topic                   =  $request->topic;
            $data->title                   =  $request->title;
            $data->title_seo               =  $seo;
            $data->link                    =  $request->link;
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
    
            $data->save();
            DB::commit();
            return redirect('/admin/viralblog')->with('success' , 'data update successfully');
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
            $data = ViralPost::find($id);
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            $subcategory =  DB::table('sub_categories')->where('category' , $data->category)->orderby('subcategory' , 'asc')->get();
            $topic =  DB::table('topics')->where('subcategory' , $data->subcategory)->orderby('topic' , 'asc')->get();

            return view('admin.viralpost.edit' , compact('data' , 'category' , 'subcategory' ,'topic'));
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
              'link'  => 'required|string',
              'sort_description'  => 'required|string',
              'long_description' => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
              $id       =   Crypt::decrypt($request->id);
              $seo      =   $this->seoName($request->title);
              $data     =   ViralPost::find($id);
            if( !empty($seo)){
              $seoCheck1 = ViralPost::where('title_seo' , $seo)->first();
              $seoCheck2 =   Post::where('title_seo' , $seo)->first();
              if(! empty($seoCheck1) || !empty($seoCheck2)){
                if($data->id  !== $seoCheck1->id) {
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
        $data->link                    =  $request->link;
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

        $data->update();
        DB::commit();
        return redirect('/admin/viralblog')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
        try {
            $id =  Crypt::decrypt($request->id);
            $data = ViralPost::find($id);
            $data->delete();
            return redirect('/admin/viralblog')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

