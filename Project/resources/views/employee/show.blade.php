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
            <h3 class="page-title"> Employee Info </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <td>{{$data->employeeID}}</td>
                                    </tr>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{$data->firstName}}</td>
                                    </tr>
                                    <tr>
                                        <th>Last Name</th>
                                        <td>{{$data->lastName}}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>{{$data->phone}}</td>
                                    </tr>
                                    <tr>
                                        <th>Age</th>
                                        <td>{{$data->age}}</td>
                                    </tr>
                                    <tr>
                                        <th>Gender</th>
                                        <td>{{$data->gender}}</td>
                                    </tr>
                                    <tr>
                                        <th>Position</th>
                                        <td>{{$data->position}}</td>
                                    </tr>
                                    <tr>
                                        <th>Salary</th>
                                        <td>{{$data->salary}}</td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <div style="display:flex; justify-content:center;margin-top:20px;align-items:center;">
                                <div style="margin-right:20px">
                                    <a href="{{ route('employee.edit',$data->employeeID) }}" class="btn btn-primary">Edit</a>
                                </div>
                                <form action=" {{ route('employee.destroy',$data->employeeID) }}" method="POST" style="display:inline">
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
