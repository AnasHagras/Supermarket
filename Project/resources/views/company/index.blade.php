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
            <h3 class="page-title"> Companies </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    @if (Session::has('msg'))
                    <div class="alert alert-success">{{ Session::get('msg') }}</div>
                    @endif
                    <div class="card-body">
                        <form style="display: flex;" method="POST" action="" class="searchForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Employee Name" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
                        </p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>CompanyID</th>
                                        <th>CompanyName</th>
                                        <th>CompanyEmail</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $company)
                                    <tr>
                                        <td>{{$company->companyID}}</td>
                                        <td>{{$company->companyName}}</td>
                                        <td>{{$company->companyEmail}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('company.show',$company->companyID) }}">Show</a></label>
                                            <label class="badge badge-warning"><a href="{{ route('company.edit',$company->companyID) }}">Edit</a></label>
                                            <form action="{{route('company.destroy',$company->companyID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td align="center" colspan="4">No Data</td>
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
    const tableName = "companies";
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
                type: 12,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response['status'] == 200) {
                    companies = JSON.parse(response['companies']);
                    document.querySelector("tbody").innerHTML = "";
                    companies.forEach(function(company) {
                        tr = document.createElement("tr");
                        firstNameTD = document.createElement("td");
                        IDTD = document.createElement("td");
                        lastNameTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        firstNameTD.innerHTML = company['companyName'];
                        lastNameTD.innerHTML = company['companyEmail'];
                        IDTD.innerHTML = company['companyID'];
                        actionTD.innerHTML = `
                        <label class="badge badge-success show"><a href="">Show</a></label>
                        <label class="badge badge-warning edit"><a href="">Edit</a></label>
                        <form class="delete" action="" method="POST" style="display:inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                        </form>`;
                        $editLink = actionTD.querySelector(".edit a");
                        $deleteLink = actionTD.querySelector(".delete");
                        $showLink = actionTD.querySelector(".show a");
                        $showLink.setAttribute("href", `http://localhost:8000/company/${company['companyID']}`);
                        $editLink.setAttribute("href", `http://localhost:8000/company/${company['companyID']}/edit`);
                        $deleteLink.setAttribute("action", `http://localhost:8000/company/${company['companyID']}`);
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