
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
            <h3 class="page-title"> User Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div  class="table-responsive">
                            <table  class="table">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <td>{{$data->userID}}</td>
                                    </tr>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{$data->name}}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{$data->email}}</td>
                                    </tr>
                                    <tr>
                                        <th>Role</th>
                                        <td>
                                            @if ($data->isAdmin)
                                                {{'Admin'}}
                                            @else
                                                {{'User'}}
                                            @endif</td>
                                    </tr>
                                    @if (($data->employeeID))
                                        <tr>
                                        <th>EmployeeID</th>
                                        <td><a href=" {{ route('employee.show',$data->employeeID) }} ">{{$data->employeeID}}</a></td>
                                    </tr>
                                    @endif

                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="{{route('user.edit',$data->userID)}}" class="btn btn-primary">Edit</a>
                                </div>
                                <form action="{{route('user.destroy',$data->userID)}}" method="POST" style="display:inline">
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
