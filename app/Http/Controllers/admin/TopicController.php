<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request ;
use App\Models\Topic ;
use Illuminate\Support\Facades\Validator;
use Crypt ;
use DB ;
use Auth ;

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
            $data =  Topic::leftJoin('categories' ,'topics.category' , '=' , 'categories.id')
            ->leftJoin('sub_categories' ,'topics.subcategory' , '=' , 'sub_categories.id')
            ->select('topics.*' , 'categories.category as category_name' , 'sub_categories.subcategory as subcategory_name')
            ->orderby('topic' , 'asc')->get();

             return view('admin.topic.index' , compact('data'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

   
    public function create()
    {
         try {
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();

            return view('admin.topic.create' ,compact('category') );
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
            $data->category                =  $request->category;
            $data->subcategory             =  $request->subcategory;
            $data->topic                   =  $request->topic;
            $data->topic_seo               =  $seo;
            $data->topic_priority          =  $request->priority;
            $data->uid                     =  Auth::user()->id;
            $data->status                  =  'pending';
            
            if (!empty($request->thumbnail)) {
              $value = $request->thumbnail;
              $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
              $extension = $value->getClientOriginalExtension();
              if (in_array($extension, $allowedExtensions)) {
                  $thumbnail = md5(time()) . '.' . $extension;
                  $value->move(public_path() . '/data/thumbnail/', $thumbnail);
                  $data->topic_thumbnail = $thumbnail;
              } else {
                  return redirect()->back()->withInput()->with('error','Something went wrong with thumbnail image');
              }
            }
            if (!empty($request->banner)) {
              $value = $request->banner;
              $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
              $extension = $value->getClientOriginalExtension();
              if (in_array($extension, $allowedExtensions)) {
                  $banner = md5(time()) . '.' . $extension;
                  $value->move(public_path() . '/data/banners/', $banner);
                  $data->topic_banner = $banner;
              } else {
                  return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
              }
            }

            $data->save();
            DB::commit();
            return redirect('/admin/topic')->with('success' , 'data store successfully');
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
            $data = Topic::find($id);
            $subcategory  =  DB::table('sub_categories')->where('category', $data->category)
            ->orderby('subcategory', 'asc')->get();
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            return view('admin.topic.edit' , compact('data' , 'category', 'subcategory'));
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
                'priority' => 'required|numeric',
                'topic'  => 'required|string',
               
               // 'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id = Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->topic);

        DB::beginTransaction();
        $data                          =  Topic::find($id);
        $data->category                =  $request->category;
        $data->subcategory             =  $request->subcategory;
        $data->topic                   =  $request->topic;
        $data->topic_seo               =  $seo;
        $data->topic_priority          =  $request->priority;
        if (!empty($request->thumbnail)) {
          $value = $request->thumbnail;
          $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
          $extension = $value->getClientOriginalExtension();
          if (in_array($extension, $allowedExtensions)) {
              $thumbnail = md5(time()) . '.' . $extension;
              $value->move(public_path() . '/data/thumbnail/', $thumbnail);
              $data->topic_thumbnail = $thumbnail;
          } else {
              return redirect()->back()->withInput()->with('error','Something went wrong with thumbnail image');
          }
        }
        if (!empty($request->banner)) {
          $value = $request->banner;
          $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
          $extension = $value->getClientOriginalExtension();
          if (in_array($extension, $allowedExtensions)) {
              $banner = md5(time()) . '.' . $extension;
              $value->move(public_path() . '/data/banners/', $banner);
              $data->topic_banner = $banner;
          } else {
              return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
          }
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
            $id =  Crypt::decrypt($request->id);
            $data = Topic::find($id);
            $data->delete();
            return redirect('/admin/topic')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}

