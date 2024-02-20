@extends('layouts.master_layout')
@section('title')
<title> myblog | Blogging Website | {{ $data->title }} </title>
<meta name="description" content="{{ $data->title }}" />
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

    p {

        word-spacing: 3px;
    }

    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        height: 300px;
    }

    .ck-rounded-corners .ck.ck-editor__main>.ck-editor__editable,
    .ck.ck-editor__main>.ck-editor__editable.ck-rounded-corners {
        height: 300px;
    }

</style>


<section class="blog-list bg-light section" id="start_page_from_here">
    <h1 class="customheading"> {{ $data->title }}</h1>
    <div class="container">
        <div class="row">
            <div class="primary col-md-12">
                <article class="post">
                    <div class="post-thumbnail">


                        <img alt="" class="img-responsive" src="{{ url('public/data/post/' . $data->post_banner) }}">

                    </div>
                    <div class="post-meta">
                        <a href="{{ url('tags/' . $data->subcategory_seo) }}" class="post-rubric">{{ $data->subcategory_name }}</a>
                        <div class="post-date">
                            <div class="time">{{ mdyformat('j F , Y', $data->created_at) }} &nbsp;</div>
                        </div>
                        <div class="post-author">
                            by <a href="#" class="author">{{ $data->username }} </a>
                        </div>
                    </div>


                    <div class="continer">


                        <div class="text-muted" id="mainx">


                            {!! $data->long_description !!}

                        </div>
                        <h3> Comment's </h3>
                        <div style=" padding: 10px;">


                            @foreach($comments as $value)
                            <div class="">
                                <h5 class="text-dark bold" style="border-left: 1px solid grey; padding: 4px;"># {{ $value->name }} <small> {{ date('j M Y', strtotime($value->created_at)) }} </small> </h5>
                                <div style="padding-left: 20px;"> {!! $value->comment !!} </div>

                            </div>

                            @endforeach
                        </div>

                        <form method="post" action="{{ route('get-blog-comment-add')}}" class='form'>
                            @csrf
                            <input type="hidden" name="id" value="{{Crypt::encrypt($data->id)}}" />
                            <input type="hidden" name="name" value="{{ $data->title_seo }}" />
                            <label for="comment"> Add Comment </label>
                            <textarea name="comment" class="form-control" rows="20" id="myeditor" ></textarea>
                            <button type="submit" class="btn" style="margin-top: 10px;"> Submit </button>
                        </form>
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

                                                                <img alt="" class="img-responsive" src="{{ url('public/data/post/' . $value->post_banner) }}">

                                                            </div>
                                                        </a>
                                                    </div>
                                                    <div class="blog-info">
                                                        <a href="{{ url('tags/' . $value->subcategory_seo) }}" class="blog-rubric">{{ $value->subcategory_name }}</a>
                                                        <h3 class="blog-title">
                                                            <a href="{{ url('/' . $value->title_seo) }}">{{ $value->title }}</a>
                                                        </h3>
                                                        <div class="blog-meta">
                                                            <div class="pull-left">
                                                                <div class="time">
                                                                    {{ mdyformat('j F , Y', $value->created_at) }}
                                                                </div>
                                                            </div>
                                                            <div class="pull-right">
                                                                <a href="{{ url('/' . $value->title_seo) }}" class="read-more">Read more &rarr;</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="overview text-center">
                                            <a href="{{ url('category/' . $data->category_seo) }}" class="btn btn-white load-more">More posts </a>
                                        </div>
                                    </div>
                                    <div class="secondary col-md-4">
                                        <div class="widget widget_search">
                                            <h3 class="widget-title">Search in blog</h3>
                                            <form class="search-form" method="POST" action="{{ url('search') }}">
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
                                            <h3 class="widget-title">Categories</h3>
                                            @php $getCategory = getCategory(); @endphp
                                            <ul>
                                                @foreach ($getCategory as $value)
                                                <li><a href="{{ url('category/' . $value->category_seo) }}" @if ($data->category === $value->id) style="color : #425cbb;" @endif>{{ $value->category }}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="widget widget_tags">
                                            <h3 class="widget-title">Tags</h3>
                                            <div class="blog-tags">
                                                @php $getSubCategory = getSubCategory(); @endphp
                                                <div class="blog-tags">
                                                    @foreach ($getSubCategory as $value)
                                                    <a href="{{ url('tags/' . $value->subcategory_seo) }}" @if ($data->subcategory === $value->id) class="subcategoryActive" @endif>{{ $value->subcategory }}</a>
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
                                            <h6 class="blog-title"> <a href="{{ url('/' . $value->title_seo) }}" class="text-decoration-none text-dark">{{ $value->title }}</a> <small class="pl-2">{{ mdyformat('j F , Y', $value->created_at) }}</small> </h6>
                                            @endforeach

                                            {{-- </ul> --}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </section>
                    </footer>
                </article>
            </div>

        </div>
    </div>
</section>


@endsection


@section('js_bottom')
<script>
    $(document).ready(function() {
        // console.log("working properly");
        // $('html, body').animate({
        //     scrollTop: $('#start_page_from_here').offset().top
        // }, 'slow');

    });

</script>
@endsection
