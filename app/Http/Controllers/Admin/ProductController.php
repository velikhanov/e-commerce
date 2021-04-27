<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return view('auth.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', '<>', NULL)->get();
        return view('auth.products.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      Session::flash('properties', $request->properties);
      $request->validate([
        'properties' => 'min:1',
        'properties.*.key' => 'min:1',
        'properties.*.value' => 'min:1',
        'category_id' => 'required|min:1'
        ]);
        $data = $request->all();
        $data['url'] = mb_strtolower(preg_replace('/(?!^)\s+/', '_', preg_replace('/[^\00-\255]+/u', '', $request->url)));
        $data['updated_at'] = Carbon::now();
        $data['created_at'] = Carbon::now();
        $product = Product::create($data);
        if ($request->hasFile('prodimg')){
            $i = 1;
            foreach ($request->file('prodimg') as $prodimg) {
              $dataimg['product_id'] = $product->id;
              $dataimg['path'] = 'img_'.rand(1, 999).time().'.'.$prodimg->getClientOriginalExtension();
              $dataimg['position'] = $i++;
              $dataimg['updated_at'] = Carbon::now();
              $dataimg['created_at'] = Carbon::now();
              $prodimg->storeAs('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX', $dataimg['path'], 'google');
              ProductImage::create($dataimg);
            };
          };
          // else{
          //   $dataimg['product_id'] = $product->id;
          //   $dataimg['path'] = '/img/products/no-img.png';
          //   $dataimg['position'] = "1";
          //   $dataimg['updated_at'] = Carbon::now();
          //   $dataimg['created_at'] = Carbon::now();
          //   ProductImage::create($dataimg);
          // };
        return redirect()->route('products.index')->with('success', 'Продукт '.$product->name.' добавлен успешно!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    // public function show(Product $product)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::where('parent_id', '<>', NULL)->get();
        foreach ($product->productImage as $prod) {
         $prodimg = null; //define it here as null
          if(isset($prod->path)){
            $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($prod->path, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($prod->path, PATHINFO_EXTENSION))
            ->first();
             $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
          };
          $prod['img_prod_prev_img'] = $prodimg; // create a new field called img_url and assign value
        };
        return view('auth.products.form', compact('product' ,'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
      Session::flash('properties', $request->properties);
      $request->validate([
        'properties' => 'min:1',
        'properties.*.key' => 'min:1',
        'properties.*.value' => 'min:1',
        ]);
        $data = $request->all();
        $data['url'] = mb_strtolower(preg_replace('/(?!^)\s+/', '_', preg_replace('/[^\00-\255]+/u', '', $request->url)));
        $data['updated_at'] = Carbon::now();
        $product->update($data);
        if(isset($request->imgfordel)){
          foreach($request->imgfordel as $del) {

              if(isset($del->img)){
                $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
                $file = $contents
                ->where('type', '=', 'file')
                ->where('filename', '=', pathinfo($del->img, PATHINFO_FILENAME))
                ->where('extension', '=', pathinfo($del->img, PATHINFO_EXTENSION))
                ->first();
              };
              isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->delete($file['path']):NULL):NULL;

            ProductImage::where('path', $del)->delete();
          };
          $editpos = 1;
          foreach ($product->productImage as $imgpos) {
            $datapos = $request->all();
            $datapos['position'] = $editpos;
            $editpos++;
            $imgpos->update($datapos);
          };
        };
        if ($request->hasFile('prodimg')){
          // $product->productImage?$i = (ProductImage::latest('position')->value('position') + 1):$i = 1;
          $product->productImage?$i = ($product->productImage()->latest('position')->value('position') + 1):$i = 1;
          foreach ($request->file('prodimg') as $prodimg) {
            $dataimg['product_id'] = $product->id;
            $dataimg['path'] = 'img_'.rand(1, 999).time().'.'.$prodimg->getClientOriginalExtension();
            $dataimg['position'] = $i++;
            $dataimg['updated_at'] = Carbon::now();
            $dataimg['created_at'] = Carbon::now();
            $prodimg->storeAs('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX', $dataimg['path'], 'google');
            ProductImage::create($dataimg);
          };
        };
        return redirect()->route('products.edit', ['product' => $product->id])->with('success', 'Данные продукта '.$product->name.' успешно обновлены!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
      if($product->productImage){
        foreach ($product->productImage as $prod) {
          if(isset($prod->img)){
            $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($prod->img, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($prod->img, PATHINFO_EXTENSION))
            ->first();
          };
          isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->delete($file['path']):NULL):NULL;
          $prod->delete();
        }
      }
        $product->delete();

        return redirect()->route('products.index')->with('danger', 'Продукт '.$product->name.' успешно удален!');
    }
}
