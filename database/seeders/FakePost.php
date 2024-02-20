<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Str;

class FakePost extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i= 0 ; $i < 300 ; $i ++) { 
 
           $num =  $i % 2 == 0  ? 2 : 1 ;
         DB::table('viral_posts')->insert([
            'uid' => 1 , 
            'category' => 2 , 
            'subcategory'  => 3  ,
            'topic'  => $num , 
            'link'  => Str::random(10) , 
            'title'  => Str::random(30) ,
            'title_seo' =>  Str::random(30), 
            'sort_description' => Str::random(60), 
            'long_description'  => Str::random(1000)
         ]);
        }
        
    }
}
