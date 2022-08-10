@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add User</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{route('user.store')}}" class="forms-sample" autocomplete = 'off'>
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input value="{{ old('name') }}" type="text" class="form-control" name="name" id="name" placeholder="Name" >
                                    <small  class="form-text" style="color: red">{{$errors->first('name')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input value="{{ old('username') }}" type="text" class="form-control" name="username" id="username" placeholder="Username" value="" autocomplete="off">
                                    <small  class="form-text" style="color: red">{{$errors->first('username')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input value="{{ old('email') }}" type="email" class="form-control" name="email" id="email" placeholder="">
                                    <small  class="form-text" style="color: red">{{$errors->first('email')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input  type="password" class="form-control" name="password" id="password" placeholder="" value="">
                                    <small  class="form-text" style="color: red">{{$errors->first('password')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select style="color: white"  class="form-control" name="isAdmin" id="role" placeholder="">
                                        <option  disabled selected>Select Role</option>
                                        <option value='0'>User</option>
                                        <option value='1'>Admin</option>
                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('isAdmin')}}</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Employee</label>
                                    <select style="color: white" name="employeeID" class="form-control">
                                        <option value="" disabled selected>Select Employee</option>
                                        @forelse ($employees as $employee)
                                            <option value="{{$employee->employeeID}}">{{$employee->firstName . " " . $employee->lastName }}</option>
                                        @empty
                                            <option value=""disabled selected>No Employees</option>
                                        @endforelse
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
