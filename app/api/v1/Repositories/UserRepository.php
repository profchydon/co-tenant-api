<?php

namespace App\Api\v1\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Api\v1\Mail\SendMail;


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

        try {

            // Check if email exist
            $emailExist = User::whereEmail($request->email)->first();

            // Check if phone number exist
            $phoneNumberExist = User::where('phone_number' , $request->phone_number)->first();

            if ($emailExist) {

                $user = "Email address already exist";
                return $user;

            }elseif ($phoneNumberExist) {

                $user = "Phone number already exist";
                return $user;

            }elseif (!$emailExist && !$phoneNumberExist) {

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
                  'user_group' => "user",
                  'active' => 0
                ]);

                if (!$user) {

                  // If User isn't created, rollback database to initial state
                  DB::rollback();

                  return $user = "Oops! Sorry there was an error. Please try again";

                }else {

                  // If User is created, commit transaction to the database
                  DB::commit();

                  return $user;

                }

            }

        } catch (\Exception $e) {

            return "Oops! Sorry there was an error. Please try again";

        }

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

        try {

            // Fetch User with email and api_key from database
            $user = User::where('api_key' , $request->header('Authorization'))->first();

            if ($user) {

                // Update user details
                $user->update($request->all());

                return $user;

            }elseif (!$user) {

                return  $user = "User details not found";

            }

        } catch (\Exception $e) {

            return "Oops! Sorry there was an error. Please try again";

        }

    }

    public function sendVerificationMail($user){

      $mail = new Mail();

      return $mail->to($user->email)->send(new SendMail($user));

    }


    /**
     * Fetch all Users existing in the database
     *
     * @return object $users
     *
     */
    public function users()
    {

        try {

            // Fetch all users existing in the database
            $users = User::all();

            // return list of users;
            return $users;

        } catch (\Exception $e) {

            return "Oops! Sorry there was an error. Please try again";

        }


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

        try {

          // Fetch user with $id from database
          $user = User::findOrfail($id);

          // return user
          return $user;

        } catch (\Exception $e) {

            return "Oops! Sorry there was an error. Please try again";

        }

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

        try {

          // Fetch user with email from database
          return $user = User::whereEmail($email)->first();

        } catch (\Exception $e) {

            return "Oops! Sorry there was an error. Please try again";

        }

    }

    public function isUserActive($request)
    {

        $user = User::whereEmail($request->email)->where('password' , Hash::make($request->password))->first();

        return $user->active ? true : false;

    }


}

?>
