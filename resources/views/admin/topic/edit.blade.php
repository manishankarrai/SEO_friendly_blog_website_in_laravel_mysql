@php
    $active_menu = '';
    $active_sub_menu = 'topic';
@endphp
@extends('layouts.admin_master')
@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Topics</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Topics</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Edit Topics</h4>

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
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-body">
                            <form name="addNewsfrm" enctype="multipart/form-data"
                                action="{{ route('admin-topic-update', Crypt::encrypt($data->id)) }}" method="POST">
                                @csrf
                                <div class="live-preview">
                                    <div class="row gy-4">



                                        <div class="col-md-12 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Topics</label>
                                                <input type="text" class="form-control"  id="topic" value="{{ $data->topic}}" name="topic">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-3 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Priority</label>
                                                <input type="number" class="form-control"  id="priority" value="{{$data->topic_priority}}" name="priority">
                                            </div>

                                        </div>
                                       


                                 @role('admin')
                                        <div class="col-md-3 col-12">
                                            <div>
                                                <label for="basiInput" class="form-label">Status</label>
                                                <select class="form-select select2"  id="status_" name="status">
                                                    <option value="" selected> Select </option>
                                                    <option value="active" @if('active' == $data->status)  selected @endif>Active</option>
                                                    <option value="inactive" @if('inactive' == $data->status)  selected @endif>Inactive</option>
                                                    <option value="pending" @if('pending' == $data->status)  selected @endif>Pending</option>
                                                    <option value="block" @if('block' == $data->status)  selected @endif>Block</option>
                                                    <option value="deleted" @if('deleted' == $data->status)  selected @endif>Deleted</option>

                                                </select>
                                            </div>
                                        </div>
                                    @endrole

                                        <div class="col-md-2 col-6">
                                            <div>
                                                <br>
                                                <input type="Submit" class="btn btn-primary mt-2" value="Update">
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

