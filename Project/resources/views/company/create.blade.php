@extends('layouts.master')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">Add Company</h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-responsive">
                            <form method="POST" action="{{route('company.store')}}" class="forms-sample">
                                @csrf

                                <div class="form-group">
                                    <label for="companyName">Name</label>
                                    <input value="{{old('companyName')}}" type="txt" class="form-control" name="companyName" id="companyName" placeholder="Company Name">
                                    <small  class="form-text" style="color: red">{{$errors->first('companyName')}}</small>
                                </div>
                                <div class="form-group">
                                    <label for="companyEmail">Email</label>
                                    <input value="{{old('companyEmail')}}" type="email" class="form-control" name="companyEmail" id="companyEmail" placeholder="Company Email">
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
