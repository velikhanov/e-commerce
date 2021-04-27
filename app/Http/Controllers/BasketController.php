<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Classes\Cart;

class BasketController extends Controller
{
  public function basket(){
    if(!Session::has('cart')){
      return view('basket');
    }
    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    return view('basket', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
  }

  public function addCart(Request $request, $id){
    $product = Product::find($id);
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->add($product, $product->id);

    $request = Session::put('cart', $cart);

    return response()->json([
         'total_quantity' => Session::has('cart') ? Session::get('cart')->totalQty : '0',
         'notif_text' => 'Product ' .'<strong>' . $product->name .'</strong>' . ' added to cart!'
     ]);
  }

  public function increaseCart($id){
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->increase($id);

    Session::put('cart', $cart);
    $product = Product::find($id);

    return redirect()->back()->with('inc-product', $product->name);
  }

  public function reduseCart($id){
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->reduse($id);

    if(count($cart->items) > 0){
    Session::put('cart', $cart);
  }else {
    Session::forget('cart');
  }
    $product = Product::find($id);

    return redirect()->back()->with('red-product', $product->name);
  }

  public function deleteCart($id){
    $oldCart = Session::has('cart') ? Session::get('cart') : NULL;
    $cart = new Cart($oldCart);
    $cart->delete($id);

    if(count($cart->items) > 0){
    Session::put('cart', $cart);
  }else {
    Session::forget('cart');
  }

    $product = Product::find($id);

    return redirect()->back()->with('del-product', $product->name);
  }

  public function clearCart(){
    Session::forget('cart');
    return redirect()->back();
}

  public function new_order(){

    if(!Session::has('cart')){
      return view('basket');
    }

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);
    return view('order', ['products' => $cart->items, 'totalPrice' => $cart->totalPrice]);
  }

  public function new_order_place(Request $request){

    $oldCart = Session::get('cart');
    $cart = new Cart($oldCart);

    $order = new Order();
    $order->cart = serialize($cart);

      $order->name = $request->input('name')?$request->input('name'):Auth::user()->name;
      $order->email = $request->input('e-mail')?$request->input('e-mail'):Auth::user()->email;
      $phone = $request->input('phone')?$request->input('phone'):(Auth::user()->phone?Auth::user()->phone:$this->validate($request, ['phone' => 'required']));
      $order->phone = str_replace(['+', ' ', '(', ')', '-'], '', $phone);
      $order->address = $request->input('address');

    Auth::check()?Auth::user()->orders()->save($order):$order->save();
    Session::forget('cart');
    return redirect()->route('basket')->with('success', 'The order is accepted for processing! Wait for a call!');
  }

  public function modal_order($id){
      $product = Product::find($id);
           $prodimg = null; //define it here as null
            if(isset($product->cardImage->path)){
              $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
              $file = $contents
              ->where('type', '=', 'file')
              ->where('filename', '=', pathinfo($product->cardImage->path, PATHINFO_FILENAME))
              ->where('extension', '=', pathinfo($product->cardImage->path, PATHINFO_EXTENSION))
              ->first();
               $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):'/img/products/no-img.png'):'/img/products/no-img.png';
            };
      return response()->json([
            'modalProdId' => $product->id,
            'name' => $product->name,
            'img' => $product->cardImage?($prodimg):('/img/products/no-img.png'),
            'price' => $product->price
       ]);
  }

  public function modal_order_place(Request $request){

    $product = Product::find($request->id);
      $prodimg = null; //define it here as null
       if(isset($product->cardImage->path)){
         $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
         $file = $contents
         ->where('type', '=', 'file')
         ->where('filename', '=', pathinfo($product->cardImage->path, PATHINFO_FILENAME))
         ->where('extension', '=', pathinfo($product->cardImage->path, PATHINFO_EXTENSION))
         ->first();
          $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):'/img/products/no-img.png'):'/img/products/no-img.png';
       };
    $selprod['items'] = array(
      $request->id => array(
          'name' => $product->name,
          'qty' => $request->qty,
          'id' => $request->id,
          'prod_url' => $product->url,
          'code_cat' => $product->category->code,
          'url_cat' => $product->category->url,
          'img' => $product->cardImage?($prodimg):('/img/products/no-img.png'),
          'cost' => $product->price*$request->qty
        )
      );
      $selprod['totalQty'] = $request->qty;
      $selprod['totalPrice'] = $product->price*$request->qty;

    $object = (object)$selprod;
    $order = new Order();

    $order->cart = serialize($object);

    $order->name = Auth::check()?(Auth::user()->name?Auth::user()->name:$request->username):$request->username;
    $order->email = Auth::check()?(Auth::user()->email?Auth::user()->email:$request->email):$request->email;
    $order->phone = Auth::check()?(Auth::user()->phone?Auth::user()->phone:$request->phone):$request->phone;

    Auth::check()?Auth::user()->orders()->save($order):$order->save();

    return response()->json([
      'notif_text' => 'The order is accepted for processing! Wait for a call!'
    ]);
  }

  public function modal_order_update(Request $request, $id){
    $product = Product::find($id);
    $modalQty = $request->qty;
      return response()->json([
            'price' => $product->price*$modalQty
       ]);
  }
}
