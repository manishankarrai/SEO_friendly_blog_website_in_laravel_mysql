<?php 

use Illuminate\Support\Facades\DB;

// if(!function_exists('getUser')){
//     function getUser(){
//       $user  =  Auth::user();
//       return $user ;
//     }
// }

if(!function_exists('mdyformat')){
      function mdyformat($dateformat,$date){
        $timestamp = is_numeric($date) ? $date : strtotime($date);
        $newdate = date($dateformat, $timestamp);
        return $newdate;
      }
}

if(!function_exists('getCategory')){
    function getCategory(){
        $category  =  DB::table('categories')->orderby('category_priority' , 'asc')->get();
        return $category ;
    }
}
if(!function_exists('getSubCategory')){
    function getSubCategory(){
        $subcategory  =  DB::table('sub_categories')->orderby('subcategory_priority' , 'asc')->get();
        return $subcategory ;
    }
}

if(!function_exists('getTopic')){
    function getTopic(){
        $topic  =  DB::table('topics')->orderby('topic_priority' , 'asc')->get();
        return $topic ;
    }
}




