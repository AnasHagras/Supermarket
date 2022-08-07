@extends('layouts.master')
@section('content')
<style>
    a{
        text-decoration: none;
        color: white;
    }
    a:hover{
        color: white;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Employees </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>EmployeeID</th>
                                        <th>FirstName</th>
                                        <th>LastName</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $employee)
                                    <tr>
                                        <td>{{$employee->employeeID}}</td>
                                        <td>{{$employee->firstName}}</td>
                                        <td>{{$employee->lastName}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('employee.show',$employee->employeeID) }}">Show</a></label>
                                            <label class="btn btn-primary"><a href="{{ route('employee.edit',$employee->employeeID) }}">Edit</a></label>
                                            <form action= "{{route('employee.destroy',$employee->employeeID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>

                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" align="center">No Data</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
