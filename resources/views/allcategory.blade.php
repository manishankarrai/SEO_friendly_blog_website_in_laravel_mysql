@extends('layouts.master_layout')
@section('title')
    <title> myblog | Blogging Website |  Category</title>
    <meta name="description" content="This blog website focuses on providing content that inspires and
    uplifts readers in their daily lives. It might cover categorys like personal development,
    motivation, and positive lifestyle choices." />
    <meta name="keywords" content="Web Development Agency, Business, Blog" />
@endsection

@section('content')
   <br>
   <br>

                    
    <section class="blog-list bg-light section">
        <div class="container-fluid">
            <div class="row">
                <div class="primary col-md-12">
                    <h3>  Category </h3>
                   
                    <div class="row-base row" id="blogarea">
                        @foreach ($data as $category)
                            <div class="col-blog col-base col-sm-4">
                                <article class="blog">
                                   
                                    <div class="blog-info">
                                        <a href="#" class="blog-rubric"></a>
                                        <h3 class="blog-title">
                                            <a href="{{ url('/category/'. $category->category_seo ) }}">{{ $category->category }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <div class="pull-left">
                                                <div class="time">{{ mdyformat('j F , Y', $category->created_at) }}</div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('/category/'. $category->category_seo ) }}" class="read-more">Visit 
                                                    &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach

                    </div>
                  
                  

                    
                </div>
               
            </div>
        </div>
    </section>
@endsection
