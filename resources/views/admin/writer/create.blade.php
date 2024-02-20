@php
    $active_menu = 'writer';
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
                        <h4 class="mb-sm-0">Writer</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Writer</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Add New Writer</h4>

                        </div><!-- end card header -->
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
                            <form name="addNewsfrm" enctype="multipart/form-data"
                                action="{{ route('admin-writer-store') }}" method="POST">
                                @csrf
                                <div class="live-preview">
                                    <div class="row gy-4">
                                       

                                        <div class="col-md-3">
                                            <div>
                                                <label for="basiInput" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name')}}" required>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-3">
                                            <div>
                                                <label for="basiInput" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" value="{{ old('email')}}" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div>
                                                <label for="basiInput" class="form-label">Password</label>
                                                <input type="text" class="form-control" id="password" value="{{ old('password')}}" name="password" required>
                                            </div>
                                        </div>

                                     


                                        <div class="col-md-2">
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
