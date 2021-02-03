@extends('admin.admin')

@section('left-column')
    <div class="row">
        <div><a href="{{ route('admin.categories') }}">Categories</a></div>
        <div><a href="{{ route('admin.products') }}">Products</a></div>
    </div>

@stop