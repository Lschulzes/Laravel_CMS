<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

  use ResetsPasswords;

  /**
   * Where to redirect users after resetting their password.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  public function reset($token)
  {
    // validate
    return view('auth.password.reset');
  }

  public function request()
  {
    // validate
    return view('auth.password.request');
  }

  public function update()
  {
    // validate
    return "<h1>Reset update request</h1>";
  }


  public function email()
  {
    // validate
    return "<h1>Email request</h1>";
  }
}
