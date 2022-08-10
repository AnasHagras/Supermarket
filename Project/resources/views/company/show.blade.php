
@extends('layouts.master')
@section('content')
<style>
    a {
        text-decoration: none;
        color: white;
    }

    a:hover {
        color: white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Company Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div  class="table-responsive">
                            <table  class="table">
                                <thead>
                                    <tr>
                                        <th>Company ID</th>
                                        <td>{{$data->companyID}}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$data->companyName}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$data->companyEmail}}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="{{route('company.edit',$data->companyID)}}" class="btn btn-primary">Edit</a>
                                </div>
                                <form action="{{route('company.destroy',$data->companyID)}}" method="POST" style="display:inline">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
