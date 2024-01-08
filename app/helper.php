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

if(!function_exists('getDummyBlogImg')){
    function getDummyBlogImg(){
         $data  = ['blog1.jpg' , 'blog2.jpg' , 'blog3.jpg' , 'blog4.jpg' ];
         $randomElement = $data[array_rand($data)];
         
        return $randomElement ;
    }
}


// like top 5  , most view suggest article are lies here 



// recomended articles lies here 



//make category subcategory in  a way that its look cools