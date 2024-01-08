<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB ;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
       // $this->checkRole();
    }
    public function dashboard(Request $request){
         try{
            return view('admin.dashboard');
        } catch( \Exception $e){
            return redirect()->back()->with('error' , 'Error found in url !');
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

    public function gettopic(Request $request){
      try {
          if(empty($request->subcategory)){
           $str  = '<option selected> Select SubCategory First  ! </option> ';
           return response()->json($str);
          }
        $topic  =  DB::table('topics')->where('subcategory', $request->subcategory)
       ->orderby('topic', 'asc')->get();
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
}
