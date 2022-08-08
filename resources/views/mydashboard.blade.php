@extends('layouts.master')
@section('content')
            <div class="main-panel">
                @if (Session::has('msg'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Not Allowed</strong> {{ Session::get('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="content-wrapper">
                    <h1>Main Dashboard</h1>
                </div>
            </div>
@endsection
