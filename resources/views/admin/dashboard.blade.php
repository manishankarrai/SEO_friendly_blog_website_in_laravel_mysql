@php
$active_menu = 'dashboard';
$active_sub_menu = '';
@endphp
@extends('layouts.admin_master')
@section('content')
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            @if (session('success'))
            <div class="alert alert-success alert-dismissible alert-fixed">
                <i class="las la-thumbs-up"></i>
                {{ session('success') }}
            </div>
            @endif
             @if (session('error'))
            <div class="alert alert-danger alert-dismissible alert-fixed">
                <i class="las la-thumbs-down"></i>
                {{ session('error') }}
            </div>
            @endif
            <!-- end page title -->

            <div class="row">
                <div class="col">

                    <div class="h-100">
                        <div class="row mb-3 pb-1">
                            <div class="col-12">
                                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                    <div class="flex-grow-1">
                                        <h4 class="fs-16 mb-1">Hello , {{ strtoupper(auth()->user()->name)}}</h4>
                                        <p class="text-muted mb-0">Here's what's happening with your blog's today.</p>
                                    </div>

                                </div><!-- end card header -->
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->




                    </div> <!-- end col -->
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Blog View
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i> {{ $blogView }}
                                    </h5>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">

                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Blog Create
                                        IN {{ now()->format('F') }} </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-muted fs-14 mb-0">
                                        {{ $thisMonthBlog }}
                                    </h5>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">


                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Blog Create
                                        IN {{ now()->format('Y') }} </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-muted fs-14 mb-0">
                                        {{ $thisYearBlog }}
                                    </h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Social View
                                    </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-success fs-14 mb-0">
                                        <i class="ri-arrow-right-up-line fs-13 align-middle"></i> {{ $socialView }}
                                    </h5>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">

                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Social Create
                                        IN {{ now()->format('F') }} </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-muted fs-14 mb-0">
                                        {{ $thisMonthSocial }}
                                    </h5>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <!-- card -->
                    <div class="card card-animate">
                        <div class="card-body">


                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1 overflow-hidden">
                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Social Create
                                        IN {{ now()->format('Y') }} </p>
                                </div>
                                <div class="flex-shrink-0">
                                    <h5 class="text-muted fs-14 mb-0">
                                        {{ $thisYearSocial }}
                                    </h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Your Top Blog's</h4>



                    </div>
                </div>
                <div class="card-body ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered  align-middle" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Writer</th>

                                        <th scope="col">Title</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">SubCategory</th>
                                        = <th scope="col">Seo</th>
                                        <th scope="col">View</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($topBlogs as $value)
                                    <tr>
                                        <th scope="row">{{ $i }}.</th>

                                        <td class="text-danger">{{ $value->status }} </td>
                                        <td class="">{{ $value->username }} </td>

                                        <td>{{ $value->title }} </td>
                                        <td>{{ $value->category_name }} </td>
                                        <td>{{ $value->subcategory_name }} </td>
                                        <td>{{ $value->title_seo }} </td>
                                        <td>{{ $value->view }} </td>
                                        <td>
                                            <div class="hstack gap-3 flex-wrap">
                                                <a href="{{ url('/' . $value->title_seo) }}" class="link-info fs-15"><i class="las la-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-5">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Your Top Social</h4>



                    </div>
                </div>
                <div class="card-body ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered  align-middle" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Writer</th>

                                        <th scope="col">Title</th>
                                        <th scope="col">Topic</th>

                                        <th scope="col">Seo</th>
                                        <th scope="col">View</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($topSocial as $value)
                                    <tr>
                                        <th scope="row">{{ $i }}.</th>

                                        <td class="text-danger">{{ $value->status }} </td>
                                        <td class="">{{ $value->username }} </td>

                                        <td>{{ $value->title }} </td>
                                        <td>{{ $value->topic_name }} </td>

                                        <td>{{ $value->title_seo }} </td>
                                        <td>{{ $value->view }} </td>
                                        <td>
                                            <div class="hstack gap-3 flex-wrap">
                                                <a href="{{ url('/topic/'.$value->topic_seo.'/'. $value->title_seo) }}" class="link-info fs-15"><i class="las la-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
                <div class="col-12 mt-5">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Top Blog Writer's</h4>



                    </div>
                </div>
                <div class="card-body ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered  align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Name</th>

                                        <th scope="col">Total Blog</th>
                                        <th scope="col">Total View</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($writers as $value)
                                    <tr>
                                        <th scope="row">{{ $i }}.</th>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->total_blogs }}</td>
                                        <td>{{ $value->total_views }}</td>


                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>






            </div>
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Top Social Writer's</h4>



                    </div>
                </div>
                <div class="card-body ">
                    <div class="live-preview">
                        <div class="table-responsive">
                            <table id="example" class="table table-bordered  align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">S.No</th>
                                        <th scope="col">Name</th>

                                        <th scope="col">Total Social</th>
                                        <th scope="col">Total View</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=1; @endphp
                                    @foreach ($writersSocial as $value)
                                    <tr>
                                        <th scope="row">{{ $i }}.</th>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->total_blogs }}</td>
                                        <td>{{ $value->total_views }}</td>


                                    </tr>
                                    @php $i++; @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>






            </div>




            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
    <!-- end main content-->
    @endsection
