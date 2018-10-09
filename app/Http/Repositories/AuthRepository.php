<?php

namespace App\Http\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

/**
 *
 */
class AuthRepository
{


  /**
  * Check user credentials
  *
  * @return \Illuminate\Http\Response
  */
  public function login($request)
  {

      $user = User::where('email', $request->email)->first();

      if(Hash::check($request->password, $user->password)) {

       $apikey = str_random(150);

       User::where('email', $request->email)->update(['api_key' => $apikey]);

       $user = User::whereEmail($request->email)->get();

       return $user;

      }else{

          return response()->json(['status' => 'fail'],401);
      }
  }


}

?>
