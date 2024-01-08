@extends('layouts.master_layout')
@section('title')
    <title> {{$subcategory->subcategory_seo}} </title>
    <meta name="description" content="{{$subcategory->subcategory_seo}}" />
    <meta name="keywords" content="Web Development Agency, Business, Blog" />
@endsection
@section('content')
                     <style>
                        .subcategoryActive {
                            color : #425cbb !important;
                        }
                        .subcategoryActive:hover {
                            color : white !important;
                        }
                     </style>
    <section class="blog-list bg-light section" id="start_page_from_here">
        <div class="container">
            <h1 class="text-left"> {{$subcategory->subcategory}} </h1>
            <div class="row">
                <div class="primary col-md-8">
                    <h3>Blogs</h3>
                    <div class="row-base row">
                        @foreach ($newblog as $blog)
                            <div class="col-blog col-base col-sm-6">
                                <article class="blog">
                                    <div class="blog-thumbnail">
                                        <a href="{{ url('/' . $blog->title_seo) }}">
                                            <div class="blog-thumbnail-img">
                                                @if ($blog->post_banner)
                                                    <img alt="" class="img-responsive"
                                                        src="{{ url('public/data/post/' . $blog->post_banner) }}">
                                                @else
                                                    @php $img  =  getDummyBlogImg(); @endphp
                                                    <img alt="" class="img-responsive"
                                                        src="{{ url('public/front/blogimg/' . $img) }}">
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                    <div class="blog-info">
                                        <a href="#" class="blog-rubric">{{ $blog->subcategory_name }}</a>
                                        <h3 class="blog-title">
                                            <a href="{{ url('/' . $blog->title_seo) }}">{{ $blog->title }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <div class="pull-left">
                                                <div class="time">{{ mdyformat('j F , Y', $blog->created_at) }}</div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('/' . $blog->title_seo) }}" class="read-more">Read more
                                                    &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach

                    </div>

                    <h3>Social Viral</h3>
                    <div class="row-base row">
                        @foreach ($newViralBlogs as $blog)
                            <div class="col-blog col-base col-sm-6">
                                <article class="blog">
                                    <div class="blog-thumbnail">
                                        <a href="{{ url('/' . $blog->title_seo) }}">
                                            <div class="blog-thumbnail-img">
                                                @if ($blog->post_banner)
                                                    <img alt="" class="img-responsive"
                                                        src="{{ url('public/data/post/' . $blog->post_banner) }}">
                                                @else
                                                    @php $img  =  getDummyBlogImg(); @endphp
                                                    <img alt="" class="img-responsive"
                                                        src="{{ url('public/front/blogimg/' . $img) }}">
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                    <div class="blog-info">
                                        <a href="#" class="blog-rubric">{{ $blog->subcategory_name }}</a>
                                        <h3 class="blog-title">
                                            <a href="{{ url('/' . $blog->title_seo) }}">{{ $blog->title }}</a>
                                        </h3>
                                        <div class="blog-meta">
                                            <div class="pull-left">
                                                <div class="time">{{ mdyformat('j F , Y', $blog->created_at) }}</div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{ url('/' . $blog->title_seo) }}" class="read-more">Read more
                                                    &rarr;</a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach

                    </div>

                    <div class="overview  text-center">
                        <a href="#" class="btn btn-white load-more">More posts</a>
                    </div>
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
                                <li><a
                                        href="{{ url('category/' . $value->category_seo) }}" @if($subcategory->category === $value->id) style="color : #425cbb;" @endif>{{ $value->category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="widget widget_tags">
                        <h3 class="widget-title">Tags</h3>
                        @php $getSubCategory =  getSubCategory(); @endphp
                        <div class="blog-tags">
                            @foreach ($getSubCategory as $value)
                                <a href="{{ url('tags/' . $value->subcategory_seo) }}" @if($subcategory->id === $value->id) class="subcategoryActive" @endif>{{ $value->subcategory }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js_bottom')

<script>
    $(document).ready(function(){
       console.log("working properly");
       $('html, body').animate({
                scrollTop: $('#start_page_from_here').offset().top
            }, 'slow');
    });
</script>

@endsection
