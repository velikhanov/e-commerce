@extends('auth.layouts.app')

@section('admin-css')
<link rel="stylesheet" href="/css/auth/prodform.css">
@endsection

@isset($product)
    @section('title-admin', 'Edit product ' . $product->name)
@else
    @section('title-admin', 'Create product')
@endisset

@section('content-admin')
    <div class="col-md-12">
        @isset($product)
            <h1>Edit product <b>{{ $product->name }}</b></h1>
        @else
            <h1>Create product</h1>
        @endisset
        @include('inc.flash')
        @foreach ($errors->all() as $error)
           <div class="alert alert-danger text-center mt-2  mb-1">{{$error}}</div>
        @endforeach
        <form method="POST" enctype="multipart/form-data"
              @isset($product)
              action="{{ route('products.update', $product) }}"
              @else
              action="{{ route('products.store') }}"
            @endisset
        >
            <div>
                @isset($product)
                    @method('PUT')
                @endisset
                @csrf
                <br>
                <div class="input-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name: </label>
                    <div class="col-sm-6">

                        <input type="text" class="form-control" name="name" id="name"
                               value="@empty($product){{old('name')}}@endempty @isset($product){{ $product->name }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="url" class="col-sm-2 col-form-label">Code: </label>
                    <div class="col-sm-6">
                      <input type="text" name="url" id="url" value="@empty($product){{old('url')}}@endempty @isset($product){{ $product->url }}@endisset">
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="category_id" class="col-sm-2 col-form-label">Category: </label>
                    <div class="col-sm-6">
                      @if($categories->isEmpty())
                      <select class="form-control">
                        <option>It looks like there is no category</option>
                      </select>
                      @else
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        @isset($product)
                                        @if($product->category_id == $category->id)
                                        selected
                                    @endif
                                    @endisset
                                >{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="description" class="col-sm-2 col-form-label">Description: </label>
                    <div class="col-sm-6">

                        <textarea name="description" id="description" cols="72"
                                  rows="7">@empty($product){{old('description')}}@endempty @isset($product){{$product->description}}@endisset</textarea>
                    </div>
                </div>
                <br>
                <div class="input-group row">
                    <label for="prodimg" class="col-sm-2 col-form-label">Images: </label>
                    <div class="col-sm-10">
                        <label class="btn btn-dark btn-file">
                            Upload <input type="file" style="display: none;" name="prodimg[]" id="prodimg" multiple>
                        </label>
                        @isset($product->productImage)
                            <div class="preview d-flex flex-wrap">
                          @foreach($product->productImage as $prodimg)
                            <a class="removeImgBtn" href="#">
                              <img src="{{$prodimg->img_prod_prev_img ?? NULL}}" alt="Preview images">
                              <span>Click to delete</span>
                              <div class="d-none">{{$prodimg->path}}</div>
                              <input type="hidden" name="imgfordel[]">
                            </a>
                          @endforeach
                            </div>
                        @else
                            <div class="preview d-inline"></div>
                        @endisset
                    </div>
                </div>
                <br>

                <div class="input-group row">
                  <label for="category_id" class="col-sm-2 col-form-label">Product properties: </label>
                  <div class="row">
                      <div class="col-lg-12">
                          @isset($product)
                            @for ($i=0; $i < (!is_null($product->properties)?count($product->properties):'0'); $i++)
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                      <input type="text" name="properties[{{ $i }}][key]" value="{{ $product->properties[$i]['key'] ?? '' }}" class="key form-control m-input ml-3" placeholder="Key" autocomplete="off">
                                      <input type="text" name="properties[{{ $i }}][value]" value="{{ $product->properties[$i]['value'] ?? '' }}" class="value form-control m-input ml-3" placeholder="Value" autocomplete="off">
                                  <div class="input-group-append ml-3">
                                      <button id="removeRow" type="button" class="btn btn-danger">Delete</button>
                                  </div>
                                </div>
                            </div>
                          @endfor
                          <input type="hidden" id="icount" value="{{(!is_null($product->properties)?count($product->properties):'0')}}">
                        @endisset
                        @empty($product)
                          @if(Session::has('properties'))
                            @for ($i=0; $i < (count(Session::get('properties'))); $i++)
                            <div id="inputFormRow">
                                <div class="input-group mb-3">
                                      <input type="text" name="properties[{{ $i }}][key]" value="{{ Session::get('properties')[$i]['key'] ?? '' }}" class="form-control m-input ml-3" placeholder="Key" autocomplete="off">
                                      <input type="text" name="properties[{{ $i }}][value]" value="{{ Session::get('properties')[$i]['value'] ?? '' }}" class="form-control m-input ml-3" placeholder="Value" autocomplete="off">
                                  <div class="input-group-append ml-3">
                                      <button id="removeRow" type="button" class="btn btn-danger">Delete</button>
                                  </div>
                                </div>
                            </div>
                          @endfor
                        @endif
                      @endempty
                          <div id="newRow"></div>
                          <button id="addRow" type="button" class="btn btn-info">Add field</button>
                      </div>
                  </div>
                </div>
                <br>
                <div class="input-group row">
                  <label for="price" class="col-sm-2 col-form-label">Price: </label>
                  <div class="row">
                      <div class="col-lg-12">
                          <input type="text" name="price" @empty($product)value="{{old('price')}}"@endempty @isset($product) value="{{ $product->price }}" @endisset id="price" placeholder="Price">
                      </div>
                  </div>
                </div>
                <br>
                <div class="input-group row">
                  <label for="status" class="col-sm-2 col-form-label">Status: </label>
                  <div class="row">
                      <div class="col-lg-12">
                        <select name="status" id="status" class="form-control">
                          <option value="1" @isset($product) @if($product->status == 1) selected @endif @endisset><span class="text-center">In stock</span></option>
                          <option value="0" @isset($product) @if($product->status == 0) selected @endif @endisset><span>Not available</span></option>
                        </select>
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
<script src="/js/imgpreview.js"></script>
<script src="/js/addinput.js"></script>
@endsection
