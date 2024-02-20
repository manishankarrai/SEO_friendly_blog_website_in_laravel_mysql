<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\ViralPost;


class Gallery extends Controller
{
    //

    public function find()
    {
        try {

            $data = [];
            if($this->roleInfo()) {
                $data =  Post::leftJoin('categories' ,'posts.category' , '=' , 'categories.id')
                 ->leftJoin('sub_categories' ,'posts.subcategory' , '=' , 'sub_categories.id')
                ->leftJoin('topics' ,'posts.topic' , '=' , 'topics.id')
                ->select('posts.*' , 'categories.category as category_name' , 'sub_categories.subcategory as subcategory_name' , 'topics.topic as topic_name')
                 ->orderby('posts.created_at' , 'desc')->get();
           } 
           return view('admin.check.blog' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error found in url !');
        }
    }
    public function find2()
    {
        try {

            $data = [];
            if($this->roleInfo()) {
                $data =  ViralPost::leftJoin('categories' ,'viral_posts.category' , '=' , 'categories.id')
                  ->leftJoin('sub_categories' ,'viral_posts.subcategory' , '=' , 'sub_categories.id')
                  ->leftJoin('topics' ,'viral_posts.topic' , '=' , 'topics.id')
                  ->select('viral_posts.*' , 'categories.category as category_name' , 'sub_categories.subcategory as subcategory_name' , 'topics.topic as topic_name')
                  ->orderby('viral_posts.created_at' , 'desc')->get();
             }
           return view('admin.check.viralblog' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error found in url !');
        }
    }
}
