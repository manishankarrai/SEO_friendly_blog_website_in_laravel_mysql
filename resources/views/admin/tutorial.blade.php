@php
$active_menu = 'tutorial';
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
                    <h4 class="mb-sm-0"> Tutorial</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tutorial</li>
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
                        <h4 class="card-title mb-0 flex-grow-1">Get Tutorial</h4>

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
                    <div class="card-body">
                        <h3 class=""> </h3>
                        <p>
                           <i class=" ri-dvd-line" > </i> First create Topic 
                        </p>
                        <p>
                          <i class=" ri-dvd-line" > </i>   Without topic no social created
                        </p>
                        <p>
                         <i class=" ri-dvd-line" > </i>   When you create a <b style="color: red"> topic </b> , you have to choose topic and then write title and description .
                        </p>
                        <p>
                           <i class=" ri-dvd-line" > </i> For blog you need to get <b style="color: red"> premium </b>
                        </p>
                        <p>
                           <i class=" ri-dvd-line" > </i> If any issue then message our team <b style="color: red"> help@myblog.com </b>
                        </p>
                         <p>
                           <i class=" ri-dvd-line" > </i> No topic deleted until they have social exist on it
                           
                        </p>
                        <p>
                           <i class=" ri-dvd-line" > </i>  Stay connected with us , <b style="color: red">soon many features coming  </b>
                           
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
