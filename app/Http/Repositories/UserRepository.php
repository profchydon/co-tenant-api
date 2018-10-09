<?php

namespace App\Http\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;


/**
 *
 */
class UserRepository
{

    public function create($request)
    {

      DB::beginTransaction();

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
        DB::rollback();
      }else {
        DB::commit();
        return $user;
      }

    }

    /**
     * Create all Users existing in the database
     *
     * @return object $user
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
     * Update a User
     *
     * @param int $id
     * @param object $request
     *
     * @return object $user
     *
     */
    public function updateUser ($id, $request)
    {
        // Fetch user with $id from database
        $user = User::findOrfail($id);

        // Update user details
        $user->update($request->all());

        // return user
        return $user;

    }

}

?>
