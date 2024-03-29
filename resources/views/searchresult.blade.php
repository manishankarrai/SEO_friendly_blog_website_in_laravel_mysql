@extends('layouts.master_layout')
@section('title')
    <title> myblog | Blogging Website | search </title>
    <meta name="description" content="search on rairesult" />
    <meta name="keywords" content="Web Development Agency, Business, Blog" />
@endsection
@section('content')
    <section class="blog-list bg-light section" id="start_page_from_here">

        <div class="container-fluid">
            <h2> Search Result</h2>
            <div class="primary">
                <div class="row">
                    @foreach ($result as $value)
                        <div class="col-blog col-base col-sm-6 col-md-4">
                            <article class="blog">
                                <div class="blog-thumbnail">
                                    <a href="#">
                                        <div class="blog-thumbnail-img">
                                           
                                                <img alt="" class="img-responsive"
                                                    src="{{ url('public/data/post/' . $value->post_banner) }}">
                                           
                                        </div>
                                    </a>
                                </div>
                                <div class="blog-info">
                                    <a href="{{ url('tags/' . $value->subcategory_seo) }}"
                                        class="blog-rubric">{{ $value->subcategory_name }}</a>
                                    <h3 class="blog-title">
                                        <a href="{{ url('/' . $value->title_seo) }}">{{ $value->title }}</a>
                                    </h3>
                                    <div class="blog-meta">
                                        <div class="pull-left">
                                            <div class="time">{{ mdyformat('j F , Y', $value->created_at) }}</div>
                                        </div>
                                        <div class="pull-right">
                                            <a href="{{ url('/' . $value->title_seo) }}" class="read-more">Read more
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

    </section>
    <!-- Footer -->
@endsection


