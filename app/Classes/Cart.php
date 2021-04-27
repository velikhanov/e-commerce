<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class Cart
{
    public $items = NULL;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart){
      if($oldCart){
        $this->items = $oldCart->items;
        $this->totalQty = $oldCart->totalQty;
        $this->totalPrice = $oldCart->totalPrice;
      }
    }
    public function add($item, $id){
      $product = Product::get();
        foreach($product as $prod){
         $prodimg = null; //define it here as null
          if(isset($prod->cardImage->path)){
            $contents = collect(Storage::disk('google')->listContents('175IwF-UY0bKpii0UXnN7lKpv8nSZ9lmX/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($prod->cardImage->path, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($prod->cardImage->path, PATHINFO_EXTENSION))
            ->first();
             $prodimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
          };
        };
      $storedItem = [
        'qty' => 0,
        'id' => $item->id,
        'prod_url' => $item->url,
        'code_cat' => $item->category->code,
        'url_cat' => $item->category->url,
        'name' => $item->name,
        'cost' => $item->price,
        'price' => $item->price,
        'img' => $item->cardImage?$prodimg:NULL
      ];
      if($this->items){
        if(array_key_exists($id, $this->items)){
          $storedItem = $this->items[$id];
        }
      }
        $storedItem['qty']++;
        $storedItem['cost'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty++;
        $this->totalPrice += $item->price;
    }

    public function increase($id){
      $this->items[$id]['qty']++;
      $this->items[$id]['cost'] += $this->items[$id]['price'];
      $this->totalQty++;
      $this->totalPrice += $this->items[$id]['price'];
    }

    public function reduse($id){
      $this->items[$id]['name'];
      $this->items[$id]['qty']--;
      $this->items[$id]['cost'] -= $this->items[$id]['price'];
      $this->totalQty--;
      $this->totalPrice -= $this->items[$id]['price'];

      if($this->items[$id]['qty'] <= 0){
        unset($this->items[$id]);
      }
    }

    public function delete($id){
        $this->totalQty -= $this->items[$id]['qty'];
        $this->totalPrice -= $this->items[$id]['cost'];
        unset($this->items[$id]);
    }
}
