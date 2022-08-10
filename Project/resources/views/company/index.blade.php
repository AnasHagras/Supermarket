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
            <h3 class="page-title"> Companies </h3>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    @if (Session::has('msg'))
                        <div class="alert alert-success">{{ Session::get('msg') }}</div>
                        @endif
                    <div class="card-body">
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
                                            <form action= "{{route('company.destroy',$company->companyID)}}" method="POST" style="display:inline">
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
@endsection
