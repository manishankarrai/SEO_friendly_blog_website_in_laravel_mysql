<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use App\Models\Post ;
use App\Models\Social ;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // $this->checkRole();
    }
    public function dashboard(Request $request){
     
         try{
        
          if($this->roleInfo()){
            
            $blogView =  DB::table('posts')->sum('view');

            $topBlogs =     Post::leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                ->leftJoin('users' ,'posts.uid' , '=' , 'users.id')
                ->select('posts.*' , 'categories.category as category_name' ,'users.name as username' , 'sub_categories.subcategory as subcategory_name' )
                ->orderby('view' , 'desc')->take(20)->get();

            
            $thisMonthBlog = DB::table('posts')
                 ->whereMonth('created_at', now()->month) 
                 ->count();
            $thisYearBlog = DB::table('posts')
                 ->whereYear('created_at', now()->year)  
                 ->count();


             $writers = DB::table('users')
               ->select('users.id', 'users.name', DB::raw('SUM(posts.view) as total_views') , DB::raw('COUNT(posts.id) as total_blogs'))
               ->join('posts', 'users.id', '=', 'posts.uid')
               ->groupBy('users.id' ,  'users.name') 
               ->orderByDesc('total_views')  
               ->get();
          

          } else {

                  
             $uid =  auth()->user()->id ;
             $blogView =  DB::table('posts')->where('uid' , $uid)->sum('view');

             $topBlogs =     Post::where('posts.uid' , $uid)
               ->whereNotIn('posts.status', ['deleted'])
               ->leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
               ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
               
               ->leftJoin('users' ,'posts.uid' , '=' , 'users.id')
               ->select('posts.*' , 'categories.category as category_name' ,'users.name as username', 'sub_categories.subcategory as subcategory_name' )
               ->orderby('view' , 'desc')->take(10)->get();
 
             
             $thisMonthBlog = DB::table('posts')->where('uid' , $uid)
                  ->whereMonth('created_at', now()->month) 
                  ->count();
             $thisYearBlog = DB::table('posts')->where('uid' , $uid)
                  ->whereYear('created_at', now()->year)  
                  ->count();
 
 
              $writers = DB::table('users')
                ->select('users.id', 'users.name', DB::raw('SUM(posts.view) as total_views') , DB::raw('COUNT(posts.id) as total_blogs'))
                ->join('posts', 'users.id', '=', 'posts.uid')
                ->groupBy('users.id' ,  'users.name') 
                ->orderByDesc('total_views')  
                ->take(5)
                ->get();

                // for user 

                $socialView =  DB::table('socials')->where('uid' , $uid)->sum('view');

                $topSocial =     Social::where('socials.uid' , $uid)
                  ->whereNotIn('socials.status', ['deleted'])
                   ->leftJoin('topics' ,'socials.topic' , '=' , 'topics.id')
                   ->leftJoin('users' ,'socials.uid' , '=' , 'users.id')
                   ->select('socials.*' , 'topics.topic as topic_name' ,'topics.topic_seo' ,'users.name as username' )
                   ->orderby('socials.view' , 'desc')->take(10)->get();

                
                $thisMonthSocial = DB::table('socials')->where('uid' , $uid)
                     ->whereMonth('created_at', now()->month) 
                     ->count();
                $thisYearSocial = DB::table('socials')->where('uid' , $uid)
                     ->whereYear('created_at', now()->year)  
                     ->count();
    
    
                 $writersSocial = DB::table('users')
                   ->select('users.id', 'users.name', DB::raw('SUM(socials.view) as total_views') , DB::raw('COUNT(socials.id) as total_blogs'))
                   ->join('socials', 'users.id', '=', 'socials.uid')
                   ->groupBy('users.id' ,  'users.name') 
                   ->orderByDesc('total_views')  
                   ->take(10)
                   ->get();




          }
         // 'blogView' , 'thisYearBlog' , 'thisMonthBlog' , 'topBlogs' , 'writers'
            return view('admin.dashboard' , compact( 'socialView'  , 'topSocial'   ,'thisMonthSocial' , 'thisYearSocial'   , 'writersSocial'   , 'blogView' , 'thisYearBlog' , 'thisMonthBlog' , 'topBlogs' , 'writers'));
            
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !'.$e->getMessage());
          }
    }
    public function getsubcategory(Request $request){
       try {
           if(empty($request->category)){
            $str  = '<option selected> Select Category First  ! </option> ';
            return response()->json($str);
           }
         $subcategory  =  DB::table('sub_categories')->where('category', $request->category)
        ->orderby('subcategory', 'asc')->get();
         $str  = '<option selected> Select </option> ';
         foreach($subcategory as $data){
              $newstr =  '<option value="'.$data->id.'" >'.$data->subcategory.'</option>';
              $str .= $newstr ;
         }

         return response()->json($str);
       } catch( \Exception $e){
         $str  = '<option selected> No SubCategory Found ! </option> ';
         return response()->json($str);
      }

    }
/*
    public function gettopic(Request $request){
      try {
          if(empty($request->subcategory)){
           $str  = '<option selected> Select SubCategory First  ! </option> ';
           return response()->json($str);
          }
          if($this->roleInfo()){
            $topic  =  DB::table('topics')->where('subcategory', $request->subcategory)
             ->orderby('topic', 'asc')->get();
          } else {
            $uid =    auth()->user()->id ;
            $topic  =  DB::table('topics')->where('uid' , $uid )->where('subcategory', $request->subcategory)
            ->orderby('topic', 'asc')->get();
          }


        $str  = '<option selected> Select </option> ';
        foreach($topic as $data){
             $newstr =  '<option value="'.$data->id.'">'.$data->topic.'</option>';
             $str .= $newstr ;
        }

        return response()->json($str);
      } catch( \Exception $e){
        $str  = '<option selected> No Topic Found ! </option> ';
        return response()->json($str);
     }

   }
   */



        public function premium(Request $request){
            return view('admin.premium');
        }
        public function tutorial(Request $request){
            return view('admin.tutorial');
        }
}
