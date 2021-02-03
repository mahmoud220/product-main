@extends('admin.admin')

@section('left-column')
    @include('admin.admin-left-column')
@stop

@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-3">Products</h3>
            <a class="btn bg-primary" href="{{route('add-product')}}">Add New Product</a>
        </div>
    </div>

    <div class="product-list">
        @include('admin.products-load')
    </div>
@stop