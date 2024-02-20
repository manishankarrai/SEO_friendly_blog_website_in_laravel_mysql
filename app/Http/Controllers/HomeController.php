<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post ;
use App\Models\Social ;
use App\Models\Category ;
use App\Models\Comment;
use App\Models\CommentSocial;

use App\Models\SubCategory;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB ;


class HomeController extends Controller
{
  
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


   
   
   
    public function index()
    {  
        
        $newblog       =  Post::whereNotIn('status', ['deleted', 'block'])->orderBy('created_at' ,'desc')->leftJoin('sub_categories' , 'posts.subcategory' , '=' , 'sub_categories.id')
                           ->select('posts.*' , 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')
                           ->take(10)->get();
        return view('index' , compact('newblog' ));
    }

    //get blog by name 
    public function getblog(Request $request){
        try {
              $seo  =  $request->name ;
              $data  =  Post::where('title_seo' , $seo)->leftJoin('sub_categories' , 'posts.subcategory' , '=' , 'sub_categories.id')
               ->leftJoin('users' , 'posts.uid' , '=' , 'users.id')
               ->leftJoin('categories' , 'posts.category' , '=' , 'categories.id')
              ->select('posts.*' , 'sub_categories.subcategory as subcategory_name' , 'sub_categories.subcategory_seo as subcategory_seo' , 'categories.category_seo as category_seo' , 'users.name as username')->first();
             
              if(!empty($data)){
                  $view = $data->view ;
                  $data->view = $view + 1;
                  $data->update();
              } else {
                return redirect()->back()->with('error' , 'Page not found !');
              }
                 $comments =  Comment::where('comments.post' , $data->id)
                         ->leftJoin('users' , 'comments.uid' , 'users.id')
                         ->select('comments.*' , 'users.name')
                         ->orderby('comments.created_at', 'asc')
                         ->get();
              
                 $similar = Post::whereNotIn('status', ['deleted', 'block'])->where('category', $data->category)
                  ->orderBy('view', 'desc')
                  ->take(6) 
                  ->get();
                  $suggest = Post::whereNotIn('status', ['deleted', 'block'])->where('posts.subcategory', $data->subcategory)
                  ->orderBy('view', 'desc')
                  ->leftJoin('sub_categories', 'posts.subcategory', '=', 'sub_categories.id')
                  ->take(6)
                  ->select('posts.*', 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')
                  ->get();
              
                
              return view('fullblog' , compact('data' , 'similar' , 'suggest' , 'comments'));
        } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !');
          }
    }

    //get blog by name 
   
    public function getSubCategory(Request $request){
       $data  =  SubCategory::all();
       return view('allsubcategory' , compact('data'));

    }
    public function getCategory(Request $request){
        $data  =  Category::all();
        return view('allcategory' , compact('data'));
 
     }
    
        //get blog by category
    public function getCategoryBySeo(Request $request){
       
        try {
              $seo            =  $request->name ;
              $category       =  DB::table('categories')->where('category_seo' , $seo)->first();
              
              $newblog        =  Post::whereNotIn('status', ['deleted', 'block'])->where('category' , $category->id)->orderBy('created_at' ,'desc')->take(10)->get();
             
             
              if(count($newblog) == 0){ 
                return redirect()->back()->with('error' , 'Post not found !');
              }
                 
              return view('bycategory' , compact('newblog' , 'category'));
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Post not found !'.$e->getMessage());
          }
    }

    public function searchpage(Request $request){
          try {
            
             $key     =  $request->key ;
             $keyword =  $this->seoName($key);
             
             $result = Post::whereNotIn('status', ['deleted', 'block'])->where('title_seo', 'like', '%' . $keyword . '%')
             ->leftJoin('sub_categories', 'posts.subcategory', '=', 'sub_categories.id')
             ->select('posts.*', 'sub_categories.subcategory as subcategory_name', 'sub_categories.subcategory_seo as subcategory_seo')->get();
         
            
              

              return view('searchresult' , compact('result' ));              
          } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !');
            }
    }
        //get blog by category
        public function getSubCategoryBySeo(Request $request){
          try {
                $seo            =  $request->name ;
                $subcategory       =  DB::table('sub_categories')->where('subcategory_seo' , $seo)->first();
                
                $newblog        =  Post::whereNotIn('status', ['deleted', 'block'])->where('subcategory' , $subcategory->id)->orderBy('created_at' ,'desc')->take(10)->get();
               
               
                if(count($newblog) == 0 ){
                  return redirect()->back()->with('error' , 'Post not found !');
                }
                   
                return view('bysubcategory' , compact('newblog'  , 'subcategory'));
          } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Post not found !');
            }
      }
    //get jquery new blog  as page in index
    public function getBlogByPage(Request $request){
        try {
              $request->validate([
                'page'=> 'required|numeric'
              ]);

             
              $skip          =  ($request->page - 1) * 10 ;
              $blogs       =  Post::whereNotIn('status', ['deleted', 'block'])->orderBy('created_at' ,'desc')->skip($skip)->take(10)->get();
             // $mostviewblog  =  ViralPost::where('category' , $category)->orderBy('view' ,'desc')->skip($skip)->take(6)->get();
               $str  = '';
              //return  $blogs ;
              if(count($blogs) == 0){
                $str =  '  <div class="col-blog col-base col-sm-12">
                <article class="blog">
                <p class="alert alert-danger" > No Blog Left ! </p> 
                </article> 
                </div>';
                return response()->json($str);
              }
              foreach($blogs as $blog){
                 $url =  url( '/' . $blog->title_seo ) ;
                 $date =  mdyformat('j F , Y', $blog->created_at) ;
                 $img =  '';
                 if($blog->post_banner){
                      $img =  url('public/data/post/' . $blog->post_banner) ;
                 } else {
                       $img_name =  ''; 
                      $img =  url('public/front/blogimg/' . $img_name) ;
                 }
                $newstr = ' <div class="col-blog col-base col-sm-6">
                <article class="blog">
                    <div class="blog-thumbnail">
                        <a href="'.$url.'">
                            <div class="blog-thumbnail-img">
                               
                                    <img alt="" class="img-responsive"
                                        src="'.$img.'">
                            </div>
                        </a>
                    </div>
                    <div class="blog-info">
                        <a href="#" class="blog-rubric">'. $blog->subcategory_name .'</a>
                        <h3 class="blog-title">
                            <a href="'.$url.'">'. $blog->title .'</a>
                        </h3>
                        <div class="blog-meta">
                            <div class="pull-left">
                                <div class="time">'. $date .' </div>
                            </div>
                            <div class="pull-right">
                                <a href="'.$url.'" class="read-more">Read more
                                    &rarr;</a>
                            </div>
                        </div>
                    </div>
                </article>
            </div>';




                $str .= $newstr ;
              }
              return response()->json($str);
        } catch( \Exception $e){
            $str = 'Error Found !'.$e->getMessage();
            return response()->json($str);
          }
    }
// for viral blog


      
    // by category 


  












public function getBlogByPageCategory(Request $request){
  try {
        $request->validate([
          'page'=> 'required|numeric' , 
          'category'=> 'required|numeric'
        ]);

       
        $skip          =  ($request->page - 1) * 10 ;
        $blogs       =  Post::where('category' , $request->category)->orderBy('created_at' ,'desc')->skip($skip)->take(10)->get();
       // $mostviewblog  =  ViralPost::where('category' , $category)->orderBy('view' ,'desc')->skip($skip)->take(6)->get();
         $str  = '';
        //return  $blogs ;
        if(count($blogs) == 0){
          $str =  ' <div class="col-blog col-base col-sm-12">
          <article class="blog">
          <p class="alert alert-danger" > No Blog Left ! </p> 
          </article> 
          </div>';
          return response()->json($str);
        }
        foreach($blogs as $blog){
           $url =  url( '/' . $blog->title_seo ) ;
           $date =  mdyformat('j F , Y', $blog->updated_at) ;
           $img =  '';
           if($blog->post_banner){
                $img =  url('public/data/post/' . $blog->post_banner) ;
           } else {
                 $img_name =  ''; 
                $img =  url('public/front/blogimg/' . $img_name) ;
           }
          $newstr = ' <div class="col-blog col-base col-sm-6">
          <article class="blog">
              <div class="blog-thumbnail">
                  <a href="'.$url.'">
                      <div class="blog-thumbnail-img">
                         
                              <img alt="" class="img-responsive"
                                  src="'.$img.'">
                      </div>
                  </a>
              </div>
              <div class="blog-info">
                  <a href="#" class="blog-rubric">'. $blog->subcategory_name .'</a>
                  <h3 class="blog-title">
                      <a href="'.$url.'">'. $blog->title .'</a>
                  </h3>
                  <div class="blog-meta">
                      <div class="pull-left">
                          <div class="time">'. $date .' </div>
                      </div>
                      <div class="pull-right">
                          <a href="'.$url.'" class="read-more">Read more
                              &rarr;</a>
                      </div>
                  </div>
              </div>
          </article>
      </div>';




          $str .= $newstr ;
        }
        return response()->json($str);
  } catch( \Exception $e){
      $str = 'Error Found !'.$e->getMessage();
      return response()->json($str);
    }
}
// for viral blog



// by sub category




public function getBlogByPageTag(Request $request){
  try {
        $request->validate([
          'page'=> 'required|numeric' , 
          'subcategory'=> 'required|numeric'
        ]);

       
        $skip          =  ($request->page - 1) * 10 ;
        $blogs       =  Post::where('subcategory' , $request->subcategory)->orderBy('created_at' ,'desc')->skip($skip)->take(10)->get();
       // $mostviewblog  =  ViralPost::where('category' , $category)->orderBy('view' ,'desc')->skip($skip)->take(6)->get();
         $str  = '';
        //return  $blogs ;
        if(count($blogs) == 0){
          $str =  ' <div class="col-blog col-base col-sm-12">
          <article class="blog">
          <p class="alert alert-danger" > No Blog Left ! </p> 
          </article> 
          </div>';
          return response()->json($str);
        }
        foreach($blogs as $blog){
           $url =  url( '/' . $blog->title_seo ) ;
           $date =  mdyformat('j F , Y', $blog->updated_at) ;
           $img =  '';
           if($blog->post_banner){
                $img =  url('public/data/post/' . $blog->post_banner) ;
           } else {
                 $img_name =  ''; 
                $img =  url('public/front/blogimg/' . $img_name) ;
           }
          $newstr = ' <div class="col-blog col-base col-sm-6">
          <article class="blog">
              <div class="blog-thumbnail">
                  <a href="'.$url.'">
                      <div class="blog-thumbnail-img">
                         
                              <img alt="" class="img-responsive"
                                  src="'.$img.'">
                      </div>
                  </a>
              </div>
              <div class="blog-info">
                  <a href="#" class="blog-rubric">'. $blog->subcategory_name .'</a>
                  <h3 class="blog-title">
                      <a href="'.$url.'">'. $blog->title .'</a>
                  </h3>
                  <div class="blog-meta">
                      <div class="pull-left">
                          <div class="time">'. $date .' </div>
                      </div>
                      <div class="pull-right">
                          <a href="'.$url.'" class="read-more">Read more
                              &rarr;</a>
                      </div>
                  </div>
              </div>
          </article>
      </div>';




          $str .= $newstr ;
        }
        return response()->json($str);
  } catch( \Exception $e){
      $str = 'Error Found !'.$e->getMessage();
      return response()->json($str);
    }
}







public function addComment(Request $request) {
      try {
        $user  =  auth()->user();
        if($user){
            $name              =   $request->name;
            $post              =   Crypt::decrypt($request->id);
            $uid               =   $user->id  ;
            $comment           =   new Comment ;
            $comment->uid      =   $uid ;
            $comment->post     =   $post ;
            $comment->comment  =   $request->comment ;
            $comment->save();  
            return redirect('/'.$name)->with('success' , 'Comment Added');

        } else {
            return redirect('/login')->with('error' , 'Please login first');
        }

      } catch( \Exception $e){

          return redirect()->back()->with('error' , 'Error Found , Please try again ! '.$e->getMessage());

      }
}


public function addCommentSocial(Request $request) {
    try {
      $user  =  auth()->user();
      if($user){
          $name              =   $request->name;
          $topic             =   $request->topic;
          $social            =   Crypt::decrypt($request->id);
          $uid               =   $user->id  ;
          $comment           =   new CommentSocial ;
          $comment->uid      =   $uid ;
          $comment->social   =   $social ;
          $comment->comment  =   $request->comment ;
          $comment->save();  
           $url =  '/topic/' . $topic .'/' . $name ;
          return redirect($url)->with('success' , 'Comment Added');

      } else {
          return redirect('/login')->with('error' , 'Please login first');
      }

    } catch( \Exception $e){

        return redirect()->back()->with('error' , 'Error Found , Please try again ! '.$e->getMessage());

    }
}









}


