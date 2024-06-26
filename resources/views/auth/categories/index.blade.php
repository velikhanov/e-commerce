@extends('auth.layouts.app')

@section('admin-css')
<link rel="stylesheet" href="/css/auth/prodindex.css">
@endsection

@section('title-admin', 'Categories')

@section('content-admin')
<div class="container emp-profile">
  <div class="col-md-12">
    @include('inc.flash')
       <h1>Категории</h1>
       <table class="table table-bordered">
           <tbody>
           <tr>
               <th class="text-center">
                   #
               </th>
               <th class="text-center">
                   Name
               </th>
               <th class="text-center">
                   Parent category
               </th>
               <th class="text-center">
                   Actions
               </th>
           </tr>
             @foreach($categories as $category)
               <tr>
                   <td>{{ $category->id }}</td>
                   <td>{{ $category->name }}</td>
                   <td class="text-center">{{ $category->parent->name ?? '-'}}</td>
                   <td class="text-center">
                       <div class="btn-group" role="group">
                           <form method="POST">
                               <a class="btn btn-warning" type="button"
                                  href="{{ route('categories.edit', $category)}}">Edit</a>
                               @csrf
                           </form>
                           <form class="ml-1" action="{{ route('categories.destroy', $category)}}" method="POST">
                             @method('DELETE')
                             @csrf
                             <input class="btn btn-danger" type="submit" value="Delete">
                           </form>
                       </div>
                   </td>
               </tr>
               @endforeach
           </tbody>
       </table>
       <a class="btn btn-success" type="button" href="{{ route('categories.create') }}">Add category</a>
   </div>
</div>
@endsection
