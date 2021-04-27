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
      $cat['img_cats_url'] = $catimg; // create a new field called img_url and assign value
     //  foreach ($cat->children as $subcat) {
     //    $subcatimg = null;
     //    if(isset($subcat->img)){
     //        $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
     //        $file = $contents
     //        ->where('type', '=', 'file')
     //        ->where('filename', '=', pathinfo($subcat->img, PATHINFO_FILENAME))
     //        ->where('extension', '=', pathinfo($subcat->img, PATHINFO_EXTENSION))
     //        ->first();
     //        $subcatimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
     //    };
     // $subcat['img_cats_url'] = $subcatimg;
     //  };
    };
    return view('categories', compact('categories'));
  }
  public function category($code, $url){
    $category = Category::with('products.cardImage')->where('url', $url)->get();
    return view('category', compact('category'));
  }
  public function product($code, $url, $suburl){
    $proditem = Product::where('url', $suburl)->get();
    // if(isset($proditem->img)){
    //   $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
    //   $file = $contents
    //   ->where('type', '=', 'file')
    //   ->where('filename', '=', pathinfo($proditem->img, PATHINFO_FILENAME))
    //   ->where('extension', '=', pathinfo($proditem->img, PATHINFO_EXTENSION))
    //   ->first();
    // };
    // $prodimg = isset($proditem->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL;
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
