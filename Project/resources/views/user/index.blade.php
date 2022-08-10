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
            <h3 class="page-title"> Users </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                        @if (Session::has('msg'))
                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                        <form style="display: flex;" method="POST" action="" class="searchForm" autocomplete='off'>
                            @csrf
                            <div class="form-group" style="margin-right:10px">
                                <input type="text" class="form-control searchText" name="searchText" id="name" placeholder=" Name" style="margin-right:10px !important">
                            </div>
                            <button type="submit" value="save" name="save" class="submitButton btn btn-primary me-2" style="padding: 10px !important; height:fit-content">Search</button>
                        </form>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>UserID</th>
                                        <th>Username</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($data as $user)
                                    <tr>
                                        <td>{{$user->userID}}</td>
                                        <td>{{$user->username}}</td>
                                        <td>
                                            <label class="badge badge-success"><a href="{{ route('user.show',$user->userID) }}">Show</a></label>
                                            <label class="btn btn-primary"><a href="{{ route('user.edit',$user->userID) }}">Edit</a></label>
                                            <form action= "{{route('user.destroy',$user->userID)}}" method="POST" style="display:inline">
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
    const tableName = "users";
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
                type: 10,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response['status']);
                if (response['status'] == 200) {
                    users = JSON.parse(response['users']);
                    document.querySelector("tbody").innerHTML = "";
                    users.forEach(function(user) {
                        tr = document.createElement("tr");
                        userIDTD = document.createElement("td");
                        usernameTD = document.createElement("td");
                        actionTD = document.createElement("td");
                        userIDTD.innerHTML = user['userID'];
                        usernameTD.innerHTML = user['username'];
                        actionTD.innerHTML = `
                        <label class="badge badge-success show"><a href="">Show</a></label>
                        <label class="btn btn-primary edit"><a href="">Edit</a></label>
                        <form class="delete" action="" method="POST" style="display:inline">
                        @csrf
                        @method("DELETE")
                        <button type="submit" style='padding:6px' class="btn btn-danger btn-sm">Delete</button>
                        </form>`;
                        $editLink = actionTD.querySelector(".edit a");
                        $deleteLink = actionTD.querySelector(".delete");
                        $showLink = actionTD.querySelector(".show a");
                        $showLink.setAttribute("href",`http://localhost:8000/user/${user['userID']}`);
                        $editLink.setAttribute("href",`http://localhost:8000/user/${user['userID']}/edit`);
                        $deleteLink.setAttribute("action",`http://localhost:8000/user/${user['userID']}`);
                        tr.appendChild(userIDTD);
                        tr.appendChild(usernameTD);
                        tr.appendChild(actionTD);
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
