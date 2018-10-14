<?php

namespace App\Api\v1\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;


class UserRepository
{

    /**
   * Create a  new User
   *
   * @param object $request
   *
   * @return object $user
   *
   */
    public function create($request)
    {

      // Begin database transaction
      DB::beginTransaction();

      // Create User
      $user = User::create([
        'email' => strtolower($request->email),
        'password' => Hash::make($request->password),
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'gender' => $request->gender,
        'phone_number' => $request->phone_number,
        'user_group' => $request->user_group,
        'active' => 0
      ]);

      if (!$user) {

        // If User isn't created, rollback database to initial state
        DB::rollback();

      }else {

        // If User is created, commit transaction to the database
        DB::commit();

        return $user;

      }

    }

    /**
     * Fetch all Users existing in the database
     *
     * @return object $users
     *
     */
    public function users()
    {
      // Fetch all users existing in the database
      $users = User::all();

      // return list of users;
      return $users;

    }

    /**
     * Fetch a User
     *
     * @param int $id
     *
     * @return object $user
     *
     */
    public function fetchAUser($id)
    {
      // Fetch user with $id from database
      $user = User::findOrfail($id);

      // return user
      return $user;

    }

    /**
     * Fetch a User using email
     *
     * @param int $email
     *
     * @return object $user
     *
     */
    public function fetchAUserUsingEmail($email)
    {
      // Fetch user with email from database
      return $user = User::whereEmail($email)->first();
    }

    /**
     * Update a User
     *
     * @param int $id
     *
     * @param object $request
     *
     * @return object $user
     *
     */
    public function updateUser ($request)
    {

        // Fetch User with email and api_key from database
        $user = User::whereEmail($request->email)->where('api_key' , $request->header('Authorization'))->first();

        if ($user) {

            // Update user details
            $user->update($request->all());

            return $user;

        }elseif (!$user) {

          return  $user = "User details not found";

        }

    }

}

?>
