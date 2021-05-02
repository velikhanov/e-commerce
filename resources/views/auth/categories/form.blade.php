@extends('auth.layouts.app')

@section('admin-css')
<link rel="stylesheet" href="/css/auth/prodform.css">
@endsection

@isset($category)
    @section('title-admin', 'Edit category ' . $category->name)
@else
    @section('title-admin', 'Create category')
@endisset

@section('content-admin')
    <div class="col-md-12">
        @isset($category)
            <h1>Edit category <b>{{ $category->name }}</b></h1>
        @else
            <h1>Create category</h1>
        @endisset
        @include('inc.flash')
      @foreach ($errors->all() as $error)
           <div class="alert alert-danger text-center mt-2  mb-1">{{$error}}</div>
      @endforeach
        <form method="POST" enctype="multipart/form-data"
              @isset($category)
              action="{{ route('categories.update', $category) }}"
              @else
              action="{{ route('categories.store') }}"
            @endisset
        >
            <div>
                @isset($category)
                    @method('PUT')
                @endisset
                @csrf
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-6">

                        <input type="text" class="form-control" name="name" id="name"
                               value="@empty($category){{old('name')}}@endempty @isset($category){{ $category->name }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Relation: </label>
                    <div class="col-sm-6">

                        <select name="parent_id" id="parent_id" class="form-control">
                            @empty($category->parent)
                              <option selected value="">-</option>
                            @endempty
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    @isset($category)
                                      @isset($category->parent)
                                        @if($cat->id == $category->parent->id)
                                          selected
                                        @endif
                                      @endisset
                                    @endisset
                                >{{$cat->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="prodimg" class="col-sm-2 col-form-label">Category: </label>
                    <div class="col-sm-10">
                            <input type="text" name="code" id="code" value="@empty($category){{old('code')}}@endempty @isset($category){{ $category->code }}@endisset">
                        </div>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="prodimg" class="col-sm-2 col-form-label">Subcategory: </label>
                    <div class="col-sm-10">
                            <input type="text" name="url" id="url" value="@empty($category){{old('url')}}@endempty @isset($category){{ $category->url }}@endisset">
                        </div>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="prodimg" class="col-sm-2 col-form-label">Image: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-dark btn-file">
                            Upload <input type="file" style="display: none;" name="catimg" id="catimg">
                        </label>
                        <div class="preview d-inline">
                        @isset($category)
                          @if(!is_null($category->img && $prevcatimg))
                            <img src="{{$prevcatimg ?? NULL}}" alt="Preview images">
                          @endif
                        @else
                            <img style="display: none;" src="" alt="Preview images">
                        @endisset
                        </div>
                    </div>
                </div>
                <br>
                <button class="btn btn-success">Save</button>
            </div>
        </form>
    </div>
@endsection
@section('pagesjs')
<script src="/js/imgpreviewcat.js"></script>
<script src="/js/selectdisable.js"></script>
@endsection
