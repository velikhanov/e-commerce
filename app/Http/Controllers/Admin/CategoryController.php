<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent')->get();
        return view('auth.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('auth.categories.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      // dd($request);
      $data = $request->all();

      if($request->parent_id != NULL){
        $parent_category_code = Category::select('name')->where('id', $request->parent_id)->first();
      }

      $request->parent_id == NULL ? $data['code'] = 'categories' : $data['code'] = strtolower($parent_category_code->name);
      $data['url'] = strtolower($request->name);

      if ($request->hasFile('catimg')){
        $data['img'] = 'img_'.rand(1, 999).time().'.'.$request->file('catimg')->getClientOriginalExtension();
        $request->file('catimg')->storeAs('categories', $data['img']);
      };

      $data['updated_at'] = Carbon::now();
      $data['created_at'] = Carbon::now();
      $category = Category::create($data);
      return redirect()->route('categories.index')->with('success', 'Category '.$category->name.' added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    // public function show(Category $category)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        return view('auth.categories.form', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
      $data = $request->all();

      if($request->parent_id != NULL){
        $parent_category_code = Category::select('name')->where('id', $request->parent_id)->first();
      }

      $data['code'] = empty($request->parent_id) || $request->parent_id == '-' ? 'categories' : strtolower($parent_category_code->name);

      $data['url'] = strtolower($request->name);
      
      if(isset($request->imgfordel)){
        Storage::disk('public')->exists('categories/'.$category->id.'/'.$data['imgfordel'])?Storage::disk('public')->delete('categories/'.$category->id.'/'.$data['imgfordel']):NULL;
        $data['img'] = NULL;
      };

      if ($request->hasFile('catimg')){
        Storage::disk('public')->exists('categories/'.$category->img)?Storage::disk('public')->delete('categories/'.$category->img):NULL;
        $data['img'] = 'img_'.rand(1, 999).time().'.'.$request->file('catimg')->getClientOriginalExtension();
        $request->file('catimg')->storeAs('categories', $data['img']);
      }
      $data['updated_at'] = Carbon::now();

      $category->update($data);

      return redirect()->route('categories.edit', $category)->with('success', 'Category '.$category->name.' added successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
      Storage::disk('public')->exists('categories/'.$category->img)?Storage::disk('public')->delete('categories/'.$category->img):NULL;
      $category->delete();
      return redirect()->route('categories.index')->with('danger', 'Category '.$category->name.' deleted successfully!');
    }
}
