@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">User details</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{ route('user.update',$data->userID) }}" class="forms-sample">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="txt" class="form-control" name="name" id="name" value="{{old('name',$data->name)}}" placeholder="Name">
                                    <small  class="form-text" style="color: red">{{$errors->first('name')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="txt" class="form-control" value="{{old('username',$data->username)}}" name="username" id="username" placeholder="Username">
                                    <small  class="form-text" style="color: red">{{$errors->first('username')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="txt" class="form-control" value="{{old('email',$data->email)}}" name="email" id="email" placeholder="">
                                    <small  class="form-text" style="color: red">{{$errors->first('email')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control"  name="password" id="password" placeholder="">
                                    <small  class="form-text" style="color: red">{{$errors->first('password')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select style="color: white"  class="form-control" name="isAdmin" id="role" placeholder="">
                                        <option @if ($data->isAdmin == '0')
                                                @selected(true)
                                        @endif value='0'>User</option>
                                        <option @if ($data->isAdmin == '1')
                                                @selected(true)
                                        @endif value='1'>Admin</option>
                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('isAdmin')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="role">Employee</label>
                                    <select style="color: white"  class="form-control" name="employeeID" id="employeeID" placeholder="">
                                        <option value="">None</option>
                                        @foreach($employees as $employee)
                                            <option @if ($data->employeeID == $employee->employeeID || old('employeeID') ==  $employee->employeeID)
                                                    @selected(true)
                                            @endif value="{{$employee->employeeID}}">{{$employee->firstName . " ". $employee->lastName}}</option>
                                        @endforeach
                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('employeeID')}}</small>
                                </div>
                                <button type="submit" value="save" name="save" class="btn btn-primary me-2">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
