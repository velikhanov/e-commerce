<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\User;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(function () {
            return view('auth.ident.login');
        });
        Fortify::authenticateUsing(function (Request $request) {
          $user = User::where('email', $request->email)->first();

          if ($user &&
              Hash::check($request->password, $user->password)) {
              return $user;
          }
        });
        Fortify::registerView(function () {
            return view('auth.ident.register');
        });
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.passwords.forgot-password');
        });
        Fortify::resetPasswordView(function ($request) {
            return view('auth.passwords.reset-password', ['request' => $request]);
        });
    }
}
