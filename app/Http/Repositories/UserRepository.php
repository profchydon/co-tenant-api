<?php

namespace App\Http\Repositories;

use App\User;
use Illuminate\Http\Request;


/**
 *
 */
class UserRepository
{

  function __construct(argument)
  {
    // code...
  }

  public function create(Request $request)
  {
    // code...

    $createUser = new User(request(['email', 'first_name', 'last_name', 'gender', 'phone_number', 'user_group']));
    if ($createUser) {
      // code...
      return true;
    }else {
      return false;
    }
  }


}



 ?>
