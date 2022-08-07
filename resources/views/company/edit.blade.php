@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Company details</h3>
        </div>
        <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{ route('company.update',$data->companyID) }}" class="forms-sample">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="companyName">Name</label>
                                    <input  type="text" class="form-control" id="companyName" name="companyName" placeholder="Company Name" value='{{old('companyName',$data->companyName) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('companyName')}}</small>
                                </div>

                                <div class="form-group">
                                    <label for="companyName">Email</label>
                                    <input type="email" class="form-control" id="companyEmail" name="companyEmail" placeholder="Company Email" value='{{old('companyEmail',$data->companyEmail) }}'>
                                    <small  class="form-text" style="color: red">{{$errors->first('companyEmail')}}</small>
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
