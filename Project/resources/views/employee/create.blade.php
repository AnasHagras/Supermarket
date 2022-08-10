
@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Employee </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{route('employee.store')}}" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input value="{{ old('firstName') }}" type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
                                    <small class="form-text" style="color: red">{{$errors->first('firstName')}}</small>


                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input value="{{ old('lastName') }}" type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
                                        <small class="form-text" style="color: red">{{$errors->first('lastName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input value="{{ old('phone') }}" type="txt" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                                        <small class="form-text" style="color: red">{{$errors->first('phone')}}</small>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label >Gender</label>
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input @if (old('gender') == 'male')
                                                    @checked(true)
                                                @endif type="radio" class="form-check-input" name="gender" id="male" value="male" > Male </label>
                                            </div>
                                        </div>
                                    <div class="col-sm-5">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input @if (old('gender') == 'female')
                                                @checked(true)
                                            @endif type="radio" class="form-check-input" name="gender" id="female" value="female"> Female </label>
                                        </div>
                                    </div>

                                        <small class="form-text" style="color: red">{{$errors->first('gender')}}</small>

                                </div>
                        </div>
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input value="{{ old('age') }}" type="number"  class="form-control" name="age" id="age">
                                    <small class="form-text" style="color: red">{{$errors->first('age')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="salary">Salary</label>
                                    <input value="{{ old('salary') }}" type="number" step="0.01" class="form-control" name="salary" id="salary">
                                    <small class="form-text" style="color: red">{{$errors->first('salary')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select style="color: white" class="form-control" name="position" id="position">
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="cashier">Casher</option>
                                        <option value="manager">Manager</option>
                                        <option value="delivery">Delivery</option>
                                    </select>
                                        <small  class="form-text" style="color: red">{{$errors->first('position')}}</small>
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
