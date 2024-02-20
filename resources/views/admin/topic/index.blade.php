@php
 $active_menu = "";
 $active_sub_menu = "topic";
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
                            <li class="breadcrumb-item active">Topics</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="col-md-12 text-right" style="padding-bottom: 20px;">
            @role('admin')
            <a href="{{ route('admin-topic-pending') }}" class="btn btn-primary">  Pending</a>
            <a href="{{ route('admin-topic-deleted') }}" class="btn btn-primary">  Deleted</a>
            @endrole
            <a href="{{ route('admin-topic-create') }}" class="btn btn-primary">+ Add New </a>
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
                                            @role('admin')
                                            <th scope="col">Status</th>
                                            @endrole
                                          <th scope="col">Name</th>
                                           
                                            <th scope="col">Seo</th>
                                            <th scope="col">Priority</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $i=1; @endphp
			                            @foreach($data as $value)
                                        <tr>
                                            <th scope="row">{{ $i }}.</th>
                                            @role('admin')
                                            <td class="text-danger">{{ $value->status }} </td>
                                            @endrole
                                            <td>{{ $value->topic }} </td>
                                            
                                            <td>{{ $value->topic_seo }} </td>
                                            <td>{{ $value->topic_priority }} </td>
                                             <td>
                                                <div class="hstack gap-3 flex-wrap">
                                                    <a href="{{ url('admin/topic/edit/'.Crypt::encrypt($value->id)) }}" class="link-success fs-15"><i class="ri-edit-2-line"></i></a>
                                                    <a href="{{ url('admin/topic/delete/'.Crypt::encrypt($value->id)) }}"  class="link-danger fs-15"><i class="ri-delete-bin-line"></i></a>
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
