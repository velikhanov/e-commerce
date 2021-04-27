<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;


class MainController extends Controller
{
  public function index(){
    $proditem = Category::with('products.cardImage')->get();
      foreach($proditem as $product)
        foreach($product->products as $prod)
         $prodimg = null; //define it here as null
          if(isset($prod->productImage->path)){
            $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($prod->productImage->path, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($prod->productImage->path, PATHINFO_EXTENSION))
            ->first();
             $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
          };
          $prod['img_prod_url'] = $prodimg;
        };
      };
    return view('index', compact('proditem'));
  }
  public function categories($code){
    $categories = Category::with('products.cardImage')->where('code', $code)->get();
    foreach ($categories as $cat) {
     $catimg = null; //define it here as null
      if(isset($cat->img)){
        $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($cat->img, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($cat->img, PATHINFO_EXTENSION))
        ->first();
         $catimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
      };
      $cat['img_cats_url'] = $catimg;
    };
    return view('categories', compact('categories'));
  }
  public function category($code, $url){
    $category = Category::with('products.cardImage')->where('url', $url)->get();
    return view('category', compact('category'));
  }
  public function product($code, $url, $suburl){
    $proditem = Product::where('url', $suburl)->get();
      foreach ($proditem as $prodit) {
        foreach ($prodit->productImage as $prod) {
         $prodimg = null; //define it here as null
          if(isset($prod->path)){
            $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($prod->path, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($prod->path, PATHINFO_EXTENSION))
            ->first();
             $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
          };
          $prod['img_prod_url'] = $prodimg;
        };
      };
    return view('products', compact('proditem'));
  }
  public function paydel(){
    return view('paydel');
  }
  public function contacts(){
    return view('contacts');
  }
  public function aboutus(){
    return view('aboutus');
  }
}
