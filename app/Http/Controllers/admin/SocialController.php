<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use App\Models\Social ;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Auth ;

class SocialController extends Controller
{


    public function index()
    {
 
           try {  
                
            
            if($this->roleInfo()) {
                 $data =  Social::leftJoin('topics' ,'socials.topic' , '=' , 'topics.id')
                 ->leftJoin('users' ,'socials.uid' , '=' , 'users.id')
                 ->select('socials.*'  ,  'users.name as username',  'topics.topic as topic_name' ,'topics.topic_seo')
                  ->orderby('socials.created_at' , 'desc')->get();
                 
            } else {
                $uid =  auth()->user()->id ;
                $data =  Social::where('socials.uid' , $uid )
                ->whereNotIn('socials.status', ['deleted'])
                ->leftJoin('topics' ,'socials.topic' , '=' , 'topics.id')
                ->select('socials.*'  ,  'topics.topic as topic_name' , 'topics.topic_seo')
                ->orderby('socials.created_at' , 'desc')->get();
            }
             $type =  'social';
     
             return view('admin.social.index' , compact('data' ,'type'));
           }   catch( \Exception $e){
           
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

    public function getPending()
    {
           try {  
            if($this->roleInfo()) {
                 $data =  Social::where('socials.status' , 'pending')
                 ->leftJoin('topics' ,'socials.topic' , '=' , 'topics.id')
                 ->leftJoin('users' ,'socials.uid' , '=' , 'users.id')
                 ->select('socials.*' ,   'users.name as username' , 'topics.topic as topic_name')
                  ->orderby('socials.created_at' , 'desc')->get();
            } 

            $type =  'pending';
             return view('admin.social.index' , compact('data' , 'type'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

    public function getDeleted()
    {
           try {  
            if($this->roleInfo()) {
                 $data =  Social::where('socials.status' , 'deleted')
                  ->leftJoin('topics' ,'socials.topic' , '=' , 'topics.id')
                  ->leftJoin('users' ,'socials.uid' , '=' , 'users.id')
                  ->select('socials.*' ,  'users.name as username'   , 'topics.topic as topic_name')
                  ->orderby('socials.created_at' , 'desc')->get();
            } 
            $type =  'deleted';
             return view('admin.social.index' , compact('data' , 'type'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }
   
    public function create()
    {
         try {
            $uid  = auth()->user()->id ;
            $topics =  DB::table('topics')->where('uid' , $uid)->orderby('topic' , 'asc')->get();
            // dd($category);
            return view('admin.social.create' , compact('topics'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }

       
       
    }

   
    public function store(Request $request)
    {
         
             //   dd($request->all());
          try {
             $validator = Validator::make($request->all(), [
             
              'topic'  => 'required|numeric',
              'title'  => 'required|string',
                'long_description' => 'required|string',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seo   =   $this->seoName($request->title);
            if( !empty($seo)){
             
              $seoCheck =   Social::where('title_seo' , $seo)->first();
              if( !empty($seoCheck)){
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
        
            }
            DB::beginTransaction();
            $data                          =    new Social;
         
            $data->topic                   =  $request->topic;
            $data->title                   =  $request->title;
            $data->title_seo               =  $seo;
            
            $data->long_description        =  $request->long_description;
    
            $data->uid                     =  Auth::user()->id;
            $data->status                  =  'active';
            $data->view                    =   0;
         
           
    
            $data->save();
            DB::commit();
            return redirect('/admin/social')->with('success' , 'data update successfully');
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
            $id             =  Crypt::decrypt($request->id);
            $data           =  Social::find($id);


             $topic =  DB::table('topics')->where('uid' , $data->uid)->orderby('topic' , 'asc')->get();

            return view('admin.social.edit' , compact('data'  ,'topic'));


          } catch( \Exception $e){

            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }

    
    public function update(Request $request)
    {
            
      try {
          $validator = Validator::make($request->all(), [
           
              'topic'  => 'required|numeric',
              'title'  => 'required|string',
              
              'long_description' => 'required|string',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id    =  Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->title);
        $data  =  Social::find($id);
        if( !empty($seo)){
          
          $seoCheck =   Social::where('title_seo' , $seo)->first();
          if( !empty($seoCheck)){
           
            if($data->id  !== $seoCheck->id) {
                return redirect()->back()->withInput()->with('error' , 'Same Seo title exist , please make small changes in your title ! ');
              }
            }
        }
        DB::beginTransaction();
        
     
        $data->topic                   =  $request->topic;
        $data->title                   =  $request->title;
        $data->title_seo               =  $seo;
        
        $data->long_description        =  $request->long_description;

        if($this->roleInfo()){
          $data->status                   =  $request->status;
        } else {
          $data->status                   =  'pending';
        }
       

     
       

        $data->update();
        DB::commit();
        return redirect('/admin/social')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
         try {
            $id   =  Crypt::decrypt($request->id);
            $data =  Social::find($id);
            if (!$data) {
              return redirect()->back()->with('error' , 'Error found in url !');
            }
         
            $data->status = 'deleted';
            $data->update();
            return redirect('/admin/social')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

