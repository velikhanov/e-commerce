<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class NavigationComposer
{
  public function compose(View $view)
  {
      $catalog = Category::with('children')->where('parent_id', '=', NULL)->get();
      //
      // foreach ($catalog as $cat) {
      //   if(isset($cat->img)){
      //       // code...
      //       $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
      //       $file = $contents
      //       ->where('type', '=', 'file')
      //       ->where('filename', '=', pathinfo($cat->img, PATHINFO_FILENAME))
      //       ->where('extension', '=', pathinfo($cat->img, PATHINFO_EXTENSION))
      //       ->first();
      //   };
      //   $catimg = collect(isset($cat->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL);
      //   foreach ($cat->children as $subcat) {
      //     if(isset($subcat->img)){
      //         // code...
      //         $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
      //         $file = $contents
      //         ->where('type', '=', 'file')
      //         ->where('filename', '=', pathinfo($subcat->img, PATHINFO_FILENAME))
      //         ->where('extension', '=', pathinfo($subcat->img, PATHINFO_EXTENSION))
      //         ->first();
      //     };
      //     $subcatcoll = collect(isset($subcat->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL);
      //   };
      // };
      foreach ($catalog as $cat) {
    $catimg = null; //define it here as null
        if(isset($cat->img)){
            $contents = collect(Storage::disk('google')->listContents('askldjfDSKLsOe2sdlKJF/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($cat->img, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($cat->img, PATHINFO_EXTENSION))
            ->first();

             $catimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
        };
        $cat['img_url'] = $catimg; // create a new field called img_url and assign value
        foreach ($cat->children as $subcat) {
          $subcatimg = null;
          if(isset($subcat->img)){
              $contents = collect(Storage::disk('google')->listContents('askldjfDSKLsOe2sdlKJF/', false));
              $file = $contents
              ->where('type', '=', 'file')
              ->where('filename', '=', pathinfo($subcat->img, PATHINFO_FILENAME))
              ->where('extension', '=', pathinfo($subcat->img, PATHINFO_EXTENSION))
              ->first();
              $subcatimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL;
          };
      $subcat['img_url'] = $subcatimg;
        };
      };
      return $view->with(['catalog' => $catalog, 'catimg' => $catimg, 'subcatimg' => $subcatimg]);
  }
}
