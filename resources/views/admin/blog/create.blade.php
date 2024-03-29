@php
    $active_menu = 'blog';
    $active_sub_menu = '';
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
                                <li class="breadcrumb-item active">Add Blogs</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Add New Blogs</h4>

                        </div><!-- end card header -->
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
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible alert-fixed">
                                <ul>
                                    <li> <i class="las la-thumbs-down"></i> Error found , please check all value again !
                                    </li>
                                    @foreach ($errors->all() as $error)
                                        <li> {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            <form name="addNewsfrm" enctype="multipart/form-data" action="{{ route('admin-blog-store') }}"
                                method="POST">
                                @csrf
                                <div class="live-preview">
                                    <div class="row gy-4">




                                        <div class="col-md-6 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Category</label>
                                                <select class="form-select select2"  id="category" name="category" required>
                                                    <option value="" selected> Select </option>
                                               @foreach ($category as $value)
                                               <option value="{{ $value->id }}" >{{ $value->category }}</option>
                                               @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                        {{-- @if(old('category') == $value->id) selected @endif --}}
                                        <div class="col-md-6 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">SubCategory</label>
                                                <select class="form-select select2"  id="subcategory" name="subcategory" required>
                                                    <option value="" selected> Select </option>

                                                </select>
                                            </div>
                                        </div>
                                      
                                      
                                        <div class="col-md-3 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Banner</label>
                                                <input type="file" class="form-control" id="banner" name="banner"
                                                    accept="image/*" required>
                                            </div>

                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title"
                                                    value="{{ old('title') }}" name="title" required>
                                            </div>

                                        </div>
                                        {{-- <div class="col-md-12 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Sort Description</label>
                                                <textarea  class="form-control" id="sort_description" name="sort_description" rows="2"
                                                >{{old('sort_description')}}</textarea>
                                                
                                            </div>

                                        </div> --}}
                                        <div class="col-md-12 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label"> Description</label>
                                                <textarea  class="form-control mytextarea" id="long_description" name="long_description" rows="20">{{old('long_description')}}</textarea>
                                                
                                            </div>

                                        </div>
                                      
                                     




                                        <div class="col-md-2 col-6">
                                            <div>
                                                <br>
                                                <input type="Submit" class="btn btn-primary mt-2" value="Submit">
                                            </div>
                                        </div>



                                    </div>
                                    <!--end row-->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js_bottom')
    <script>
        console.log("work ");
        $(document).ready(function() {
            console.log("work 2");

            $("#category").change(function() {
                console.log("work 3");

                let category = $("#category").val();
                $.ajax({
                    url: "{{ url('/admin/get/subcategory') }}",
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "category": category,
                    },
                    success: function(res) {
                        $('#subcategory').html(res);
                        //console.log("work 4");

                    },
                    error: function(err) {
                        $('#subcategory').html(err);
                       // console.log("work 5");

                    }
                })
            });
            // another change
            
        });
    </script>
@endsection
