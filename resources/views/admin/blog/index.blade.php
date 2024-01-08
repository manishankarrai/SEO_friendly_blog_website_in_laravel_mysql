@php
 $active_menu = "blog";
 $active_sub_menu = "";
@endphp
@extends('layouts.admin_master')
@section('content')
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blogs</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Blogs</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="col-md-12 text-right" style="padding-bottom: 20px;">
            <a href="{{ route('admin-blog-create') }}" class="btn btn-primary">+ Add New Blog</a>
        </div>
            <div class="col-xl-12">
                <div class="card">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible alert-fixed">
                        <i class="las la-thumbs-up"></i>
                      {{ session('success') }}
                    </div>
                  @endif
                  @if(session('error'))
                    <div class="alert alert-danger alert-dismissible alert-fixed">
                        <i class="las la-thumbs-down"></i>
                      {{ session('error') }}
                    </div>
                  @endif

                    <div class="card-body">
                        <div class="live-preview">
                            <div class="table-responsive">
                                <table id="example" class="table table-bordered  align-middle" style="font-size:12px;">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">SubCategory</th>
                                            <th scope="col">Topic</th>
                                            <th scope="col">Seo</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
			                            @foreach($data as $value)
                                        <tr>
                                            <th scope="row">{{ $i; }}.</th>
                                            <td>{{ $value->title }} </td>
                                            <td>{{ $value->category_name }} </td>
                                            <td>{{ $value->subcategory_name }} </td>
                                            <td>{{ $value->topic_name }} </td>
                                            <td>{{ $value->title_seo }} </td>
                                             <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="{{ url('admin/blog/edit/'.Crypt::encrypt($value->id)) }}" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                                                    <a href="javascript:void(0);" onclick="DeleteItems('../admin/blog','delete','{{Crypt::encrypt($value->id)}}')" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
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
            </div>
        </div>
    </div>
</div>

@endsection
