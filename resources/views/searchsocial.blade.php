@extends('layouts.master_layout')
@section('title')
    <title> myblog | Blogging Website | {{ $topic->topic}} </title>
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
                    <h3> Search Result </h3>
                   
                    <div class="row-base row" id="blogarea">
                        @foreach ($result as $blog)
                            <div class="col-blog col-base col-sm-6">
                                <article class="blog">
                                   
                                    <div class="blog-info">
                                        <a href="{{ url('/topic/'.$blog->topic_seo ) }}" class="blog-rubric">{{ $blog->topic_name }}</a>
                                        <h3 class="blog-title">
                                            <a href="{{ url('/topic/'. $blog->topic_seo .'/' . $blog->title_seo) }}">{{ $blog->title }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <div class="pull-left">
                                                <div class="time">{{ mdyformat('j F , Y', $blog->created_at) }}</div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('/topic/'. $blog->topic_seo .'/' . $blog->title_seo) }}" class="read-more">Read more
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
                        <h3 class="widget-title">Search in social</h3>
                        <form class="search-form" method="POST" action="{{ url('search-in-social')}}">
                             @csrf
                            <div class="input-group">
                                <input type="search" class="input-round form-control" placeholder="Search" name="key">
                                <span class="input-group-btn">
                                    <button class="btn" type="submit"><span class="icon-arrow-right"></span></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="widget widget_categories">
                        <h3 class="widget-title">Topics</h3>
                        @php $getTopic =  getTopic(); @endphp
                        <ul>
                            @foreach ($getTopic as $value)
                                <li><a
                                        href="{{ url('topic/'.$value->topic_seo) }}" @if($value->id == $topic->id) style="color : #425cbb;"  @endif>{{ $value->topic }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                   
                </div>
            </div>
        </div>
    </section>
@endsection
