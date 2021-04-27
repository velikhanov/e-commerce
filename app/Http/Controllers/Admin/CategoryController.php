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
        $categories = Category::where('parent_id', NULL)->get();
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
      $data = $request->all();
      $request->parent_id == NULL ? $data['code'] = 'categories' : $data['code'] = $request->code;
      if ($request->hasFile('catimg')){
        $data['img'] = 'img_'.rand(1, 999).time().'.'.$request->file('catimg')->getClientOriginalExtension();
        $request->file('catimg')->storeAs('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze', $data['img'], 'google');
      };

      $data['updated_at'] = Carbon::now();
      $data['created_at'] = Carbon::now();
      $category = Category::create($data);
      return redirect()->route('categories.index')->with('success', 'Категория '.$category->name.' успешно добавлена!');
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
        $categories = Category::where('parent_id', NULL)->get();
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

        $request->parent_id == NULL ? $data['code'] = 'categories' : $data['code'] = $request->code;
        if ($request->hasFile('catimg')){
          if(isset($category->img)){
            $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($category->img, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($category->img, PATHINFO_EXTENSION))
            ->first();
          isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->delete($file['path']):NULL):NULL;
          };
          $data['img'] = 'img_'.rand(1, 999).time().'.'.$request->file('catimg')->getClientOriginalExtension();
          $request->file('catimg')->storeAs('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze', $data['img'], 'google');
        }
        $data['updated_at'] = Carbon::now();

        $category->update($data);

        return redirect()->route('categories.edit', $category)->with('success', 'Категория '.$category->name.' успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
      if(isset($category->img)){
        $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($category->img, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($category->img, PATHINFO_EXTENSION))
        ->first();
      isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->delete($file['path']):NULL):NULL;
      };
      $category->delete();
      return redirect()->route('categories.index')->with('danger', 'Категория '.$category->name.' успешно удалена!');
    }
}
