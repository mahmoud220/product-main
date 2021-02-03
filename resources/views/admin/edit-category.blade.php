@extends('admin.admin')

@section('left-column')
    @include('admin.admin-left-column')
@stop

@section('content')

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h3 class="display-3">
                @if ($category) Edit Category
                @else Add New Category
                @endif
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <form method="POST" action="{{ url('/admin/categories/') }}" enctype="multipart/form-data" class="form-horizontal">
                {{ csrf_field() }}
                @if ($category)
                    <input type="hidden" name="id" value="{{$category->id}}">
                @endif
                <div class="form-group required">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Name"
                               @if ($category) value="{{$category->name}}" @endif
                               required minlength="3" maxlength="30">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputDescription" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="text" name="description" class="form-control" id="inputDescription"
                               @if ($category) value="{{$category->description}}" @endif
                               placeholder="Description">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button class="btn btn-default" type="submit">
                            @if ($category) save
                            @else add category
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop