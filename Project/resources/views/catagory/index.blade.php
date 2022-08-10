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
            <h3 class="page-title"> Categories </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <form style="display: flex;" method="POST" action="" class="searchForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder="Category ID" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>CategoryID</th>
                                        <th>CategoryName</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $category)
                                    <tr>
                                        <td>{{$category->catagoryID}}</td>
                                        <td>{{$category->catagoryName}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('catagory.show',$category->catagoryID) }}">Show</a></label>
                                            <label class="badge badge-warning"><a href="{{ route('catagory.edit',$category->catagoryID) }}">Edit</a></label>
                                            <form action= "{{route('catagory.destroy',$category->catagoryID)}}" method="POST" style="display:inline">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td align="center" colspan="3">No Data</td>
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
    const tableName = "catagories";
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
                type: 9,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    catagories = JSON.parse(response['catagories']);
                    document.querySelector("tbody").innerHTML = "";
                    catagories.forEach(function(catagory) {
                        tr = document.createElement("tr");
                        catagoryIDTD = document.createElement("td");
                        catagoryNameTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        catagoryIDTD.innerHTML = catagory['catagoryID'];
                        catagoryNameTD.innerHTML = catagory['catagoryName'];

                        tr.appendChild(catagoryIDTD);
                        tr.appendChild(catagoryNameTD);
                        //tr.appendChild(actionTD);
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
