<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post ;
use App\Models\ViralPost ;
use DB ;


class HomeController extends Controller
{
  
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

   
    public function index()
    {  
        
        $newblog       =  Post::orderBy('created_at' ,'desc')->leftJoin('sub_categories' , 'posts.subcategory' , '=' , 'sub_categories.id')
                           ->select('posts.*' , 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')
                           ->take(6)->get();
        $newViralBlogs  =  ViralPost::orderBy('view' ,'desc')->leftJoin('sub_categories' , 'viral_posts.subcategory' , '=' , 'sub_categories.id')
                         ->select('viral_posts.*' , 'sub_categories.subcategory as subcategory_name' , 'sub_categories.subcategory_seo as subcategory_seo')
                         ->take(6)->get();
       
        return view('index' , compact('newblog' , 'newViralBlogs'));
    }

    //get blog by name 
    public function getblog(Request $request){
        try {
              $seo  =  $request->name ;
              $data  =  Post::where('title_seo' , $seo)->leftJoin('sub_categories' , 'posts.subcategory' , '=' , 'sub_categories.id')
              ->select('posts.*' , 'sub_categories.subcategory as subcategory_name' , 'sub_categories.subcategory_seo as subcategory_seo')->first();
              $type = 'post';
              if(empty($data)){
                $data = ViralPost::where('title_seo' , $seo)->leftJoin('sub_categories' , 'viral_posts.subcategory' , '=' , 'sub_categories.id')
                ->select('viral_posts.*' , 'sub_categories.subcategory as subcategory_name' , 'sub_categories.subcategory_seo as subcategory_seo')->first();
                $type = 'viralpost';
              }
              if(!empty($data)){
                  $view = $data->view ;
                  $data->view = $view + 1;
                  $data->update();
              } else {
                return redirect()->back()->with('error' , 'Page not found !');
              }
              if($type === 'post') {
                 $similar = Post::where('topic', $data->topic)
                  ->orderBy('view', 'desc')
                  ->take(6) 
                  ->get();
                  $suggest = Post::where('posts.subcategory', $data->subcategory)
                  ->orderBy('view', 'desc')
                  ->leftJoin('sub_categories', 'posts.subcategory', '=', 'sub_categories.id')
                  ->take(6)
                  ->select('posts.*', 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')
                  ->get();
              
              } else {
                  $similar = ViralPost::where('topic', $data->topic)
                  ->orderBy('view', 'desc')
                  ->take(6) 
                  ->get();
                 $suggest = ViralPost::where('viral_posts.subcategory', $data->subcategory)
                  ->orderBy('view', 'desc')
                  ->leftJoin('sub_categories' , 'viral_posts.subcategory' , '=' , 'sub_categories.id') 
                  ->take(6)
                  ->select('viral_posts.*', 'sub_categories.subcategory as subcategory_name' , 'sub_categories.subcategory_seo as subcategory_seo')
                  ->get(); 
              }     
              return view('fullblog' , compact('data' , 'similar' , 'suggest'));
        } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !'.$e->getMessage());
          }
    }

    //get blog by name 
    public function getviralblog(Request $request){
        try {
              $name  =  $request->name ;
              $data  =  ViralPost::where('title_seo' , $name)->first();
              $view = $data->view ;
              $data->view = $view + 1;
              $data->update();
              if(empty($data)){
                return redirect()->back()->with('error' , 'Post not found !');
              }
              $similar = ViralPost::where('topic', $data->topic)
                  ->orderBy('view', 'desc')
                  ->take(5)
                  ->get();
              $suggest = ViralPost::where('subcategory', $data->subcategory)
                  ->orderBy('view', 'desc')
                  ->take(5)
                  ->get();      
              return view('fullblog' , compact('data' , 'similar' , 'suggest'));
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Post not found !');
          }
    }

    
        //get blog by category
    public function getCategoryBySeo(Request $request){
        try {
              $seo            =  $request->name ;
              $category       =  DB::table('categories')->where('category_seo' , $seo)->first();
              
              $newblog        =  Post::where('category' , $category->id)->orderBy('created_at' ,'desc')->take(6)->get();
              $newViralBlogs  =  ViralPost::where('category' , $category->id)->orderBy('created_at' ,'desc')->take(6)->get();
             
             
              if(empty($newblog) && empty($newViralBlogs)){
                return redirect()->back()->with('error' , 'Post not found !');
              }
                 
              return view('bycategory' , compact('newblog' , 'newViralBlogs' , 'category'));
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Post not found !');
          }
    }

    public function searchpage(Request $request){
          try {
            
             $key     =  $request->key ;
             $keyword =  $this->seoName($key);
             
             $result = Post::where('title_seo', 'like', '%' . $keyword . '%')
             ->leftJoin('sub_categories', 'posts.subcategory', '=', 'sub_categories.id')
             ->select('posts.*', 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')->get();
         
             $viralResult = ViralPost::where('title_seo', 'like', '%' . $keyword . '%')
             ->leftJoin('sub_categories', 'viral_posts.subcategory', '=', 'sub_categories.id')
             ->select('viral_posts.*', 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')->get();
         
              

              return view('searchresult' , compact('result' , 'viralResult'));              
          } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !'.$e->getMessage());
            }
    }
        //get blog by category
        public function getSubCategoryBySeo(Request $request){
          try {
                $seo            =  $request->name ;
                $subcategory       =  DB::table('sub_categories')->where('subcategory_seo' , $seo)->first();
                
                $newblog        =  Post::where('subcategory' , $subcategory->id)->orderBy('created_at' ,'desc')->take(6)->get();
                $newViralBlogs  =  ViralPost::where('subcategory' , $subcategory->id)->orderBy('created_at' ,'desc')->take(6)->get();
               
               
                if(empty($newblog) && empty($newViralBlogs)){
                  return redirect()->back()->with('error' , 'Post not found !');
                }
                   
                return view('bysubcategory' , compact('newblog' , 'newViralBlogs' , 'subcategory'));
          } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !');
            }
      }
    //get jquery new blog in category
    public function getPostByCatgoryNewNext(Request $request){
        try {
              $category      =  $request->category ;
              $skip          =  $request->skip ;
              $newblog       =  ViralPost::where('category' , $category)->orderBy('created_at' ,'desc')->skip($skip)->take(12)->get();
             // $mostviewblog  =  ViralPost::where('category' , $category)->orderBy('view' ,'desc')->skip($skip)->take(6)->get();
             
             
              if(empty($newblog)){
                $str = 'no blog left';
                return response()->json($str);
              }
              foreach($newblog as $blog){
                $newstr = '';
                $str .= $newstr ;
              }
              return response()->json($str);
        } catch( \Exception $e){
            $str = 'Error Found !';
            return response()->json($str);
          }
    }

      
    //get jquery new blog in category
    public function getPostByCatgoryMostNext(Request $request){
        try {
              $category      =  $request->category ;
              $skip          =  $request->skip ;
             // $newblog       =  ViralPost::where('category' , $category)->orderBy('created_at' ,'desc')->skip($skip)->take(12)->get();
              $mostviewblog  =  ViralPost::where('category' , $category)->orderBy('view' ,'desc')->skip($skip)->take(12)->get();
             
             
              if(empty($mostviewblog)){
                $str = 'no blog left';
                return response()->json($str);
              }
              foreach($mostviewblog as $blog){
                $newstr = '';
                $str .= $newstr ;
              }
              return response()->json($str);
        } catch( \Exception $e){
            $str = 'Error Found !';
            return response()->json($str);
          }
    }








}
