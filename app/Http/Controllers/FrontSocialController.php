<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Social ;
use App\Models\Topic ;
use App\Models\CommentSocial;
use Illuminate\Support\Facades\DB ;


class FrontSocialController extends Controller
{
    

    public function index(Request $request)
    {  
     try {
        $newblog       =  Social::whereNotIn('socials.status', ['deleted', 'block'])
                           ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                           ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo' )
                           ->orderBy('socials.created_at' ,'desc')
                           ->take(20)->get();
           return view('social' , compact('newblog' ));
       } catch( \Exception $e) {
         return redirect()->back()->with('error'  , ' error ! '.$e->getMessage());
     }


  }

  public function getTopic(Request $request)
  {  
   try {
      $topic_seo  =  $request->topic ;
      $newblog       =  Social::whereNotIn('socials.status', ['deleted', 'block'])
                         ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                         ->where('topics.topic_seo' , $topic_seo)
                         ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo' )
                         ->orderBy('socials.created_at' ,'desc')
                         ->take(20)->get();
      $topic        =  Topic::where('topic_seo' , $topic_seo)->first();

      return view('bytopic' , compact('newblog' ,'topic' ));

   } catch( \Exception $e) {
       return redirect()->back()->with('error'  , ' error ! '.$e->getMessage());
   }


}


     public function getSocial(Request $request){
        try {
              $topic   =  $request->topic ;
              $social  =  $request->social ;

              $data  =  Social::where('title_seo' , $social)
                              ->leftJoin('users' , 'socials.uid' , '=' , 'users.id')
                              ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                              ->where('topics.topic_seo' , $topic)
                              ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo' , 'users.name as username')
                              ->first();
             
              if(!empty($data)){
                  $view = $data->view ;
                  $data->view = $view + 1;
                  $data->update();
              } else {
                return redirect()->back()->with('error' , 'Page not found !');
              }
              $comments =  CommentSocial::where('comment_socials.social' , $data->id)
                   ->leftJoin('users' , 'comment_socials.uid' , 'users.id')
                   ->select('comment_socials.*' , 'users.name')
                   ->orderby('comment_socials.created_at', 'asc')
                   ->get();
              
                 $suggest = Social::whereNotIn('socials.status', ['deleted', 'block'])
                  ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                  ->where('topics.topic_seo' , $topic)
                  ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo')
                  ->orderBy('socials.view', 'desc')
                  ->take(10) 
                  ->get();

              
                
              return view('fullSocial' , compact('data' , 'suggest' , 'comments' ));
        } catch( \Exception $e){
              return redirect()->back()->with('error' , 'Social not found !'.$e->getMessage());
          }
    }


    public function getBlogByPage(Request $request){
        try {
              $request->validate([
                'page'=> 'required|numeric'
              ]);

             
              $skip          =  ($request->page - 1) * 20 ;
              $blogs         =  Social::whereNotIn('socials.status', ['deleted', 'block'])
                                     ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                                     ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo')
                                     ->orderBy('socials.created_at' ,'desc')
                                     ->skip($skip)->take(20)->get();
               $str  = '';
              //return  $blogs ;
              if(count($blogs) == 0){
                $str =  '  <div class="col-blog col-base col-sm-12 mt-5">
                <article class="blog">
                <p class="alert alert-danger" > No Blog Left ! </p> 
                </article> 
                </div>';
                return response()->json($str);
              }
              foreach($blogs as $blog){
                 $url =  url( '/topic/'. $blog->topic_seo .'/' . $blog->title_seo ) ;
                 $topicUrl =  url( '/topic/'. $blog->topic_seo  ) ;

                 $date =  mdyformat('j F , Y', $blog->created_at) ;
                 
                $newstr = ' <div class="col-blog col-base col-sm-6">
                <article class="blog">

                    <div class="blog-info">
                        <a href="'.$topicUrl.'" class="blog-rubric">'. $blog->topic_name .'</a>
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


    public function searchpage(Request $request){
        try {
          
           $key     =  $request->key ;
           $keyword =  $this->seoName($key);
           
           $result = Social::whereNotIn('socials.status', ['deleted', 'block'])
                 ->where('socials.title_seo', 'like', '%' . $keyword . '%')
                 ->leftJoin('topics' , 'socials.topic' , '=' , 'topics.id')
                 ->select('socials.*' ,'topics.topic as topic_name' ,'topics.topic_seo' )
                 ->orderBy('socials.created_at' ,'desc')
                 ->get();
    
          
           // search topic here and show both 
            

            return view('searchsocial' , compact('result' ));              
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Social not found !');
          }
   }

   public function getAllTopic(Request $request){

     try {
        $topics = Topic::all();
           //  dd($topics);
           $name  =  'All Topic' ;

           return view('alltopic' , compact('topics'  , 'name'));
        } catch( \Exception $e) {
           return redirect()->back()->with('error'  , ' error ! '.$e->getMessage());
     }
       
   }


   public function searchInTopic(Request $request){
    try {
      
       $key     =  $request->key ;
       $keyword =  $this->seoName($key);
       
       $topics = Topic::whereNotIn('status', ['deleted', 'block'])
             ->where('topic_seo', 'like', '%' . $keyword . '%')
             ->get();

      $name  =  'Search Result' ;
       // search topic here and show both 
        

        return view('alltopic' , compact('topics' , 'name' ));              
    } catch( \Exception $e){
        return redirect()->back()->with('error' , 'Social not found !');
      }
}
}
