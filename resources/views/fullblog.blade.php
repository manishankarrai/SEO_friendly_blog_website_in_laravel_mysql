@extends('layouts.master_layout')
@section('title')
    <title> {{ $data->title_seo }} </title>
    <meta name="description" content="{{ $data->sort_description }}" />
    <meta name="keywords" content="Web Development Agency, Business, Blog" />
@endsection
@section('content')
    <!-- Blog List -->
    <style>
        .subcategoryActive {
            color: #425cbb !important;
        }

        .subcategoryActive:hover {
            color: white !important;
        }

        .text-decoration-none:hover {
            text-decoration: none;
        }
    </style>

    <section class="blog-list bg-light section" id="start_page_from_here">
        <div class="container">
            <div class="row">
                <div class="primary col-md-8">
                    <article class="post">
                        <div class="post-thumbnail">
                            @if ($data->post_banner)
                                <img alt="" class="img-responsive"
                                    src="{{ url('public/data/post/' . $data->post_banner) }}">
                            @else
                                @php $img  =  getDummyBlogImg(); @endphp
                                <img alt="" class="img-responsive" src="{{ url('public/front/blogimg/' . $img) }}">
                            @endif
                        </div>
                        <div class="post-meta">
                            <a href="{{ url('tags/' . $data->subcategory_seo) }}"
                                class="post-rubric">{{ $data->subcategory_name }}</a>
                            <div class="post-date">
                                <div class="time">{{ mdyformat('j F , Y', $data->created_at) }}</div>
                            </div>
                            <div class="post-author">
                                by <a href="#" class="author">Craig David</a>
                            </div>
                        </div>
                        <h3 class="post-title">
                            {{ $data->title }}
                        </h3>
                        <div class="text-muted">

                            {{ $data->long_description }}

                        </div>
                        <footer class="post-footer">
                            <section class="blog-list bg-light section">
                                <div class="container">
                                    <div class="row">
                                        <div class="primary col-md-8">
                                            <h2> Suggest Blog's</h2>

                                            <div class="row-base row">
                                                @foreach ($suggest as $value)
                                                    <div class="col-blog col-base col-sm-6 col-md-6">
                                                        <article class="blog">
                                                            <div class="blog-thumbnail">
                                                                <a href="#">
                                                                    <div class="blog-thumbnail-img">
                                                                        @if ($value->post_banner)
                                                                            <img alt="" class="img-responsive"
                                                                                src="{{ url('public/data/post/' . $value->post_banner) }}">
                                                                        @else
                                                                            @php $img  =  getDummyBlogImg(); @endphp
                                                                            <img alt="" class="img-responsive"
                                                                                src="{{ url('public/front/blogimg/' . $img) }}">
                                                                        @endif
                                                                    </div>
                                                                </a>
                                                            </div>
                                                            <div class="blog-info">
                                                                <a href="{{ url('tags/' . $value->subcategory_seo) }}"
                                                                    class="blog-rubric">{{ $value->subcategory_name }}</a>
                                                                <h3 class="blog-title">
                                                                    <a
                                                                        href="{{ url('/' . $value->title_seo) }}">{{ $value->title }}</a>
                                                                </h3>
                                                                <div class="blog-meta">
                                                                    <div class="pull-left">
                                                                        <div class="time">
                                                                            {{ mdyformat('j F , Y', $value->created_at) }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <a href="{{ url('/' . $value->title_seo) }}"
                                                                            class="read-more">Read more &rarr;</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="overview text-center">
                                                <a href="{{ url('category/' . $data->category_seo) }}"
                                                    class="btn btn-white load-more">More posts</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </footer>
                    </article>
                </div>
                <div class="secondary col-md-4">
                    <div class="widget widget_search">
                        <h3 class="widget-title">Search in blog</h3>
                        <form class="search-form">
                            <div class="input-group">
                                <input type="search" class="input-round form-control" placeholder="Search" name="search">
                                <span class="input-group-btn">
                                    <button class="btn" type="submit"><span class="icon-arrow-right"></span></button>
                                </span>
                            </div>
                        </form>
                    </div>
                    <div class="widget widget_categories">
                        <h3 class="widget-title">Categories</h3>
                        @php $getCategory =  getCategory(); @endphp
                        <ul>
                            @foreach ($getCategory as $value)
                                <li><a href="{{ url('category/' . $value->category_seo) }}"
                                        @if ($data->category === $value->id) style="color : #425cbb;" @endif>{{ $value->category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget widget_tags">
                        <h3 class="widget-title">Tags</h3>
                        <div class="blog-tags">
                            @php $getSubCategory =  getSubCategory(); @endphp
                            <div class="blog-tags">
                                @foreach ($getSubCategory as $value)
                                    <a href="{{ url('tags/' . $value->subcategory_seo) }}"
                                        @if ($data->subcategory === $value->id) class="subcategoryActive" @endif>{{ $value->subcategory }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="widget widget_categories">
                        <h2 class="widget-title">Similar Blog's</h2>

                        {{-- <ul> --}}
                        @foreach ($similar as $value)
                            {{-- <li >
                                   
                                </li> --}}
                            <h6 class="blog-title"> <a href="{{ url('/' . $value->title_seo) }}"
                                    class="text-decoration-none text-dark">{{ $value->title }}</a> <small
                                    class="pl-2">{{ mdyformat('j F , Y', $value->created_at) }}</small> </h6>
                        @endforeach

                        {{-- </ul> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
@endsection


@section('js_bottom')
    <script>
        $(document).ready(function() {
            console.log("working properly");
            $('html, body').animate({
                scrollTop: $('#start_page_from_here').offset().top
            }, 'slow');
        });
    </script>
@endsection
