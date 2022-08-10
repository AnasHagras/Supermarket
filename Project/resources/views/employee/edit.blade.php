@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Employee details</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{ route('employee.update',$data->employeeID) }}" class="forms-sample">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name" value='{{ old('firstName', $data->firstName) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('firstName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="txt" class="form-control" name="lastName" id="lastName" placeholder="Last Name" value='{{ old('lastName', $data->lastName) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('lastName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="sellingPrice">Phone</label>
                                    <input type="text"  class="form-control" name="phone" id="phone" value='{{ old('phone', $data->phone) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('phone')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <select style="color: white" class="form-control" name="gender" id="gender">
                                        <option @if (old('gender') == 'male' ||$data->gender == 'male') @selected(true) @endif value="male">Male</option>
                                        <option @if (old('gender') == 'female'||$data->gender == 'female') @selected(true) @endif value="female">Female</option>
                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('gender')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="purcashingPrice">Age</label>
                                    <input type="number"  class="form-control" name="age" id="age" value='{{old('age', $data->age) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('age')}}</small>
                                </div>


                                <div class="form-group">
                                    <label for="purcashingPrice">Salary</label>
                                    <input type="number" step="0.01" class="form-control" name="salary" id="salary" value='{{ old('salary', $data->salary) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('salary')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select style="color: white" class="form-control" name="position" id="position">
                                        <option value="" disabled selected>Select Position</option>
                                        <option @if ($data->position == 'cashier' || old('position') == 'cashier') @selected(true) @endif value="cashier">Cashier</option>
                                        <option @if ($data->position == 'manager'|| old('position') == 'manager') @selected(true) @endif value="manager">Manager</option>
                                        <option @if ($data->position == 'delivery'|| old('position') == 'delivery') @selected(true) @endif value="delivery">Delivery</option>
                                    </select>
                                    <small  class="form-text" style="color: red">{{$errors->first('position')}}</small>
                                </div>

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
