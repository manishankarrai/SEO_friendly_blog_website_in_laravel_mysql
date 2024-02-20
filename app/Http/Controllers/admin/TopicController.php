<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request ;
use App\Models\Topic ;
use App\Models\Social ;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Auth ;

class TopicController extends Controller
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
               $data =  Topic::orderby('topic' , 'asc')->get();
            } else {
              $uid =  auth()->user()->id ;
              $data =  Topic::where('topics.uid' , $uid )
                  ->orderby('topic' , 'asc')->get();
            }

             return view('admin.topic.index' , compact('data'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }




    public function getPending(){
      try {
        if($this->roleInfo()) {
          $data =  Topic::where('topics.status' , 'pending')->orderby('topic' , 'asc')->get();
       }
       return view('admin.topic.index' , compact('data'));
      }   catch( \Exception $e){
        return redirect()->back()->with('error' , 'Error found in url !');
     }
    }
    public function getDeleted(){
      try {
        if($this->roleInfo()) {
          $data =  Topic::where('topics.status' , 'deleted')->orderby('topic' , 'asc')->get();
       }
       return view('admin.topic.index' , compact('data'));
      }   catch( \Exception $e){
        return redirect()->back()->with('error' , 'Error found in url !');
     }
    }

   
    public function create()
    {
         try {
            return view('admin.topic.create' );
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }

       
       
    }

   
    public function store(Request $request)
    {
         
        try {
              $validator = Validator::make($request->all(), [
              
                'priority' => 'required|numeric',
                'topic'  => 'required|string',
               
               // 'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
           $seo   =   $this->seoName($request->topic);

            DB::beginTransaction();
            $data                          =  new Topic;
           
            $data->topic                   =  $request->topic;
            $data->topic_seo               =  $seo;
            $data->topic_priority          =  $request->priority;
            $data->uid                     =  Auth::user()->id;
            $data->status                  =  'pending';
            
          

            $data->save();
            DB::commit();
            return redirect('/admin/topic')->with('success' , 'data store successfully');
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
            $data = Topic::find($id);
           
            return view('admin.topic.edit' , compact('data'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }

    
    public function update(Request $request)
    {
            
      try {
           $validator = Validator::make($request->all(), [
                
                'priority' => 'required|numeric',
                'topic'  => 'required|string',
               

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id = Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->topic);

        DB::beginTransaction();
        $data                          =  Topic::find($id);
       
        $data->topic                   =  $request->topic;
        $data->topic_seo               =  $seo;
        $data->topic_priority          =  $request->priority;

        if($this->roleInfo()){
          $data->status                   =  $request->status;
        } else {
          $data->status                   =  'pending';
        }
        
       

        $data->update();
        DB::commit();
        return redirect('/admin/topic')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
     
        try {
            $id      =  Crypt::decrypt($request->id);
            $data    =  Topic::find($id);
            $social  =  Social::where('topic' , $data->id)->get();
            $noOfItem =  count($social);
            if($noOfItem == 0){
              $data->delete();
            }else {
              return redirect()->back()->with('error' , 'Blog Exit on that topic , first delete blog then delete topic  !');
            }
            return redirect('/admin/topic')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

