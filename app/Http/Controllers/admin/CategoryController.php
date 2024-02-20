<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Category ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt ;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index()
    {
           try {  
               if(! $this->roleInfo()) {
                 Auth::logout();
                 return redirect('/')->with('error' , 'Error found in url !');
               }
               $data =  Category::orderby('category' , 'asc')->get();
            return view('admin.category.index' , compact('data'));
           }   catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

   
    public function create()
    {
           try {
            if(! $this->roleInfo()) {
              Auth::logout();
              return redirect('/')->with('error' , 'Error found in url !');
            }
            return view('admin.category.create');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }

       
       
    }

   
    public function store(Request $request)
    {
         
        try {
          if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
            $validator = Validator::make($request->all(), [
                'priority' => 'required|numeric',
                'category'  => 'required|string',
               // 'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $seo   =   $this->seoName($request->category);
            DB::beginTransaction();
            $data                       = new Category;
            $data->category             =  $request->category;
            $data->category_seo         =  $seo;
            $data->category_priority    =  $request->priority;
            if (!empty($request->thumbnail)) {
              $value = $request->thumbnail;
              $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
              $extension = $value->getClientOriginalExtension();
              if (in_array($extension, $allowedExtensions)) {
                  $thumbnail = md5(time()) . '.' . $extension;
                  $value->move(public_path() . '/data/thumbnail/', $thumbnail);
                  $data->category_thumbnail = $thumbnail;
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
                  $data->category_banner = $banner;
              } else {
                  return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
              }
            }

            $data->save();
            DB::commit();
            return redirect('/admin/category')->with('success' , 'data store successfully');
          } catch( \Exception $e){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
          }
        
    }

   
    

  
    public function edit(Request $request)
    {
        try {
          if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
            $id =  Crypt::decrypt($request->id);
            $data = Category::find($id);
            return view('admin.category.edit' , compact('data'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }

    
    public function update(Request $request)
    {
            
      try {
        if(! $this->roleInfo()) {
          Auth::logout();
          return redirect('/')->with('error' , 'Error found in url !');
        }
         $validator = Validator::make($request->all(), [
                'priority' => 'required|numeric',
                'category'  => 'required|string',
               // 'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id = Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->category);
        DB::beginTransaction();
        $data                       =  Category::find($id);
        $data->category             =  $request->category;
        $data->category_seo         =  $seo;
        $data->category_priority    =  $request->priority;
        if (!empty($request->thumbnail)) {
          $value = $request->thumbnail;
          $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
          $extension = $value->getClientOriginalExtension();
          if (in_array($extension, $allowedExtensions)) {
              $thumbnail = md5(time()) . '.' . $extension;
              $value->move(public_path() . '/data/thumbnail/', $thumbnail);
              $data->category_thumbnail = $thumbnail;
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
              $data->category_banner = $banner;
          } else {
              return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
          }
        }

        $data->update();
        DB::commit();
        return redirect('/admin/category')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
        try {
          if(! $this->roleInfo()) {
            Auth::logout();
            return redirect('/')->with('error' , 'Error found in url !');
          }
            $id =  Crypt::decrypt($request->id);
            $data = Category::find($id);
            $data->delete();
            return redirect('/admin/category')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}
