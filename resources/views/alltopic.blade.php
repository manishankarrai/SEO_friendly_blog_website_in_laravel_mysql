@extends('layouts.master_layout')
@section('title')
    <title> myblog | Blogging Website | All Topic </title>
    <meta name="description" content="This blog website focuses on providing content that inspires and
    uplifts readers in their daily lives. It might cover topics like personal development,
    motivation, and positive lifestyle choices." />
    <meta name="keywords" content="Web Development Agency, Business, Blog" />
@endsection

@section('content')
   <br>
   <br>

                    
    <section class="blog-list bg-light section">
        <div class="container-fluid">
            <div class="row">
                <div class="primary col-md-8">
                    <h3>  {{ $name }} </h3>
                   
                    <div class="row-base row" id="blogarea">
                        @foreach ($topics as $topic)
                            <div class="col-blog col-base col-sm-6">
                                <article class="blog">
                                   
                                    <div class="blog-info">
                                        <a href="#" class="blog-rubric"></a>
                                        <h3 class="blog-title">
                                            <a href="{{ url('/topic/'. $topic->topic_seo ) }}">{{ $topic->topic }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <div class="pull-left">
                                                <div class="time">{{ mdyformat('j F , Y', $topic->created_at) }}</div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('/topic/'. $topic->topic_seo ) }}" class="read-more">See more
                                                    &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach

                    </div>
                  
                  

                    
                </div>
                <div class="secondary col-md-4">
                    <div class="widget widget_search">
                        <h3 class="widget-title">Search in Topic</h3>
                        <form class="search-form" method="POST" action="{{ route('search-in-topics')}}">
                             @csrf
                            <div class="input-group">
                                <input type="search" class="input-round form-control" placeholder="Search" name="key">
                                <span class="input-group-btn">
                                    <button class="btn" type="submit"><span class="icon-arrow-right"></span></button>
                                </span>
                            </div>
                        </form>
                    </div>
                   
                   
                </div>
            </div>
        </div>
    </section>
@endsection
