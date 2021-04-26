<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UsersPersonalDataComposer
{
  public function compose(View $view)
  {
    $user = Auth::user();
    if(isset($user->img)){
      $contents = collect(Storage::disk('google')->listContents('1wbJ21pzL0XZwQBVe0hqbbDhbqoUCc2Eo/', false));
      $file = $contents
      ->where('type', '=', 'file')
      ->where('filename', '=', pathinfo($user->img, PATHINFO_FILENAME))
      ->where('extension', '=', pathinfo($user->img, PATHINFO_EXTENSION))
      ->first();
    $userimg = isset($file['path'])?$file['path']:NULL;
    return response($userimg, 200)
       ->header('ContentType', $file['mimetype'])
       ->header('Content-Disposition', "attachment; filename='$user->img'");
    // $userimg = isset($file['path'])?(Storage::disk('google')->exists($file['path'])?Storage::disk('google')->get($file['path']):NULL):NULL;
    };

    return $view->with('userimg', $userimg);
  }
}
