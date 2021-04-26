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
      foreach ($catalog as $cat) {
        if(isset($cat->img)){
            // $cat = Category::
            // code...
            $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
            $file = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($cat->img, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($cat->img, PATHINFO_EXTENSION))
            ->first();
        };
        $catimgcoll = collect(isset($cat->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL);
        $catimg= $catimgcoll->get();
        foreach ($cat->children as $subcat) {
          if(isset($subcat->img)){
              // code...
              $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
              $file = $contents
              ->where('type', '=', 'file')
              ->where('filename', '=', pathinfo($subcat->img, PATHINFO_FILENAME))
              ->where('extension', '=', pathinfo($subcat->img, PATHINFO_EXTENSION))
              ->first();
          };
          $subcatimgcoll = collect(isset($subcat->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL);
          $subcatimg = $subcatimgcoll->get();
        };
      };
      return $view->with(['catalog' => $catalog, 'catimg' => $catimg, 'subcatimg' => $subcatimg]);
  }
}
