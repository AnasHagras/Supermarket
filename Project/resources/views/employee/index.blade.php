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
            <h3 class="page-title"> Employees </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card ">
                <div class="card ">
                    <div class="card-body ">
                        @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <form style="display: flex;" method="POST" action="" class="searchForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Search Text" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
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
                                            <form action="{{route('employee.destroy',$employee->employeeID)}}" method="POST" style="display:inline">
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
<script>
    const tableName = "employees";
    const form = document.querySelector(".searchForm");
    const submit = document.querySelector(".submitButton");
    // console.log(submit);
    submit.addEventListener('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "/ajaxRequest",
            type: "POST",
            data: {
                searchText: document.querySelector(".searchText").value,
                tableName: tableName,
                type: 6,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    employees = JSON.parse(response['employees']);
                    document.querySelector("tbody").innerHTML = "";
                    employees.forEach(function(employee) {
                        tr = document.createElement("tr");
                        firstNameTD = document.createElement("td");
                        IDTD = document.createElement("td");
                        lastNameTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        firstNameTD.innerHTML = employee['firstName'];
                        lastNameTD.innerHTML = employee['lastName'];
                        IDTD.innerHTML = employee['employeeID'];
                        actionTD.innerHTML = `
                        <label class="badge badge-success"><a href="{{ route('employee.show',$employee->employeeID) }}">Show</a></label>
                        <label class="btn btn-primary"><a href="{{ route('employee.edit',$employee->employeeID) }}">Edit</a></label>
                        <form action="{{route('employee.destroy',$employee->employeeID)}}" method="POST" style="display:inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                        </form>`;
                        tr.appendChild(IDTD);
                        tr.appendChild(firstNameTD);
                        tr.appendChild(lastNameTD);
                        tr.appendChild(actionTD);
                        document.querySelector("tbody").appendChild(tr);
                    });
                } else {
                    document.querySelector("tbody").innerHTML = "";
                    tr = document.createElement("tr");
                    td = document.createElement("td");
                    td.innerHTML = response['msg'];
                    tr.appendChild(td);
                    document.querySelector("tbody").appendChild(tr);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
</script>
@endsection