@php
 $active_menu = "writer";
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
                            <li class="breadcrumb-item active">Writer</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-md-12 text-right" style="padding-bottom: 20px;">
                <a href="{{ route('admin-writer-create') }}" class="btn btn-primary">+ Add New Writer</a>
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
                                <table id="example" class="table table-bordered  align-middle">
                                    <thead>
                                        <tr>
                                            <th scope="col">S.No</th>
                                            <th scope="col">Name</th>
                                            
                                            <th scope="col">Email</th>
                                            <th scope="col">Password</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
			                            @foreach($data as $value)
                                        <tr>
                                            <th scope="row">{{ $i }}.</th>
                                            <td>{{ $value->name}}</td>
                                            <td>{{ $value->email }}</td>
                                            <td>{{ $value->password }}</td>

                                            <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="{{ url('admin/writer/edit/'.Crypt::encrypt($value->id)) }}" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                                                    <a href="javascript:void(0);" onclick="DeleteItems('../admin/writer','delete','{{Crypt::encrypt($value->id)}}')" class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
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
