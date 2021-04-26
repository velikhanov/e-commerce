<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Category;

class NavigationComposer
{
  public function compose(View $view)
  {
      $catalog = Category::with('children')->where('parent_id', '=', NULL)->get();
      //
      if(isset($catalog->img)){
        // $cat = Category::
        $contents = collect(Storage::disk('google')->listContents('1lngtMrfEvcwjnJWp6b7Bxv2q5NDdYJze/', false));
        $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($catalog->img, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($catalog->img, PATHINFO_EXTENSION))
        ->first();
      };
     $catimg = isset($catalog->img)?(isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->url($file['path']):NULL):NULL):NULL;
      //
      return $view->with(['catalog' => $catalog, 'catimg' => $catimg]);
  }
}
