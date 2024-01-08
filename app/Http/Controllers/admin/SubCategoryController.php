<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\SubCategory ;
use Illuminate\Support\Facades\Validator;
use Crypt ;
use DB;
class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // $this->checkRole();
    }
   
    public function index()
    {
           try {  
            $data =  SubCategory::leftJoin('categories' ,'sub_categories.category' , '=' , 'categories.id')
            ->select('sub_categories.*' , 'categories.category as category_name')
            ->orderby('subcategory' , 'asc')->get();
             return view('admin.subcategory.index' , compact('data'));
           }   catch( \Exception $e){
             return redirect()->back()->with('error' , 'Error found in url !');
          }
       
    }

   
    public function create()
    {
         try {
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();
            return view('admin.subcategory.create' , compact('category'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }

       
       
    }

   
    public function store(Request $request)
    {
         
        try {
            $validator = Validator::make($request->all(), [
                'category' => 'required|numeric',
                'priority' => 'required|numeric',
                'subcategory'  => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
          $seo   =   $this->seoName($request->subcategory);

            DB::beginTransaction();
            $data                          = new SubCategory;
            $data->category                =  $request->category;
            $data->subcategory             =  $request->subcategory;
            $data->subcategory_seo         =  $seo;
            $data->subcategory_priority    =  $request->priority;
            if (!empty($request->thumbnail)) {
              $value = $request->thumbnail;
              $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
              $extension = $value->getClientOriginalExtension();
              if (in_array($extension, $allowedExtensions)) {
                  $thumbnail = md5(time()) . '.' . $extension;
                  $value->move(public_path() . '/data/thumbnail/', $thumbnail);
                  $data->subcategory_thumbnail = $thumbnail;
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
                  $data->subcategory_banner = $banner;
              } else {
                  return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
              }
            }

            $data->save();
            DB::commit();
            return redirect('/admin/subcategory')->with('success' , 'data store successfully');
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
            $data = SubCategory::find($id);
            $category =  DB::table('categories')->orderby('category' , 'asc')->get();

            return view('admin.subcategory.edit' , compact('data' , 'category'));
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }

    
    public function update(Request $request)
    {
            
      try {
        $validator = Validator::make($request->all(), [
                'category' => 'required|numeric',
                'priority' => 'required|numeric',
                'subcategory'  => 'required|string',
              //  'captcha' => 'required|captcha',

            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        $id = Crypt::decrypt($request->id);
        $seo   =   $this->seoName($request->subcategory);

        DB::beginTransaction();
        $data                          =  SubCategory::find($id);
        $data->category                =  $request->category;
        $data->subcategory             =  $request->subcategory;
        $data->subcategory_seo         =  $seo;
        $data->subcategory_priority    =  $request->priority;
        if (!empty($request->thumbnail)) {
          $value = $request->thumbnail;
          $allowedExtensions = ['jpg', 'jpeg', 'png' , 'svg' ];
          $extension = $value->getClientOriginalExtension();
          if (in_array($extension, $allowedExtensions)) {
              $thumbnail = md5(time()) . '.' . $extension;
              $value->move(public_path() . '/data/thumbnail/', $thumbnail);
              $data->subcategory_thumbnail = $thumbnail;
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
              $data->subcategory_banner = $banner;
          } else {
              return redirect()->back()->withInput()->with('error','Something went wrong with banner image');
          }
        }

        $data->update();
        DB::commit();
        return redirect('/admin/subcategory')->with('success' , 'data update successfully');
      } catch( \Exception $e){
        DB::rollBack();
        return redirect()->back()->withInput()->with('error' , 'Error found in url ! ');
      }
    
}
    

    
    public function destroy(Request $request)
    {
        try {
            $id =  Crypt::decrypt($request->id);
            $data = SubCategory::find($id);
            $data->delete();
            return redirect('/admin/subcategory')->with('success' , 'data deleted successfully');
          } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
          }
    }
}
