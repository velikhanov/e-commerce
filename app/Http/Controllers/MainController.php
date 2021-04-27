<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;
use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
  public function index(){
    $proditem = Category::with('products.cardImage')->get();
    return view('index', compact('proditem'));
  }
  public function categories($code){
    $categories = Category::with('products.cardImage')->where('code', $code)->get();
    return view('categories', compact('categories'));
  }
  public function category($code, $url){
    $category = Category::with('products.cardImage')->where('url', $url)->get();
    return view('category', compact('category'));
  }
  public function product($code, $url, $suburl){
    $proditem = Product::where('url', $suburl)->get();
    if(isset($proditem->category->img)){
      $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
      $file = $contents
      ->where('type', '=', 'file')
      ->where('filename', '=', pathinfo($proditem->category->img, PATHINFO_FILENAME))
      ->where('extension', '=', pathinfo($proditem->category->img, PATHINFO_EXTENSION))
      ->first();
    };
    $prodimg = isset($proditem->category->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL;
    return view('products', compact('proditem', 'prodimg'));
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
