<?php

namespace App\Api\v1\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 *
 */
class AuthRepository
{

  /**
  * Login User
  *
  *@param $request
  *
  * @return \Illuminate\Http\Response
  */
  public function login($request)
  {

      //Check if email exist
      $user = User::whereEmail($request->email)->first();

      // Check if passwords are equal
      $password = Hash::check($request->password, $user->password);

      if(!$user || !$password){

        // If email or password provided does not match
          $user = "Incorrect login details";

      }

      if($user && $password) {

          // Get the current date
          $date = Carbon::now();

          // Create a random key as api_key for the User
          $hash = Hash::make($date);
          $apikey = str_random(50)."".$hash."".str_random(150);

          // Update api_key in the user table for the particular user
          User::where('email', $request->email)->update(['api_key' => $apikey]);

          //
          $user = User::whereEmail($request->email)->first();

      }

          return $user;
  }


}

?>
