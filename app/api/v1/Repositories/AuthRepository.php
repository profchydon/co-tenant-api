<?php

namespace App\Api\v1\Repositories;

use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Verification;

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

      try {

        $user = User::whereEmail($request->email)->first();

        if (!($user === NULL)) {

          // Check if passwords are equal
          $password = Hash::check($request->password, $user->password);

        }


        if(!$user){

            // If email or password provided does not match
            $user = "Incorrect login details";

            return $user;

        }elseif(!$password){

            // If email or password provided does not match
            $user = "Incorrect login details";

            return $user;
        }
        elseif (!$this->isUserActive($request)) {

            $user = "User's account has not been verified";

            return $user;

        }elseif($user && $password) {

            // Get the current date
            $date = Carbon::now();

            // Create a random key as api_key for the User
            $hash = Hash::make($date);
            $apikey = str_random(50)."".$hash."".str_random(150);

            // Update api_key in the user table for the particular user
            User::where('email', $request->email)->update(['api_key' => $apikey]);

            //
            $user = User::whereEmail($request->email)->first();

            return $user;

        }


      } catch (\Exception $e) {

          return "Oops! Sorry there was an error. Please try again";

      }

  }

  public function isUserActive($request)
  {

      $user = User::whereEmail($request->email)->first();

      return $user->active ? true : false;

  }

  public function passwordReset($email)
  {

      $emailExist = User::whereEmail($email)->first();

      if (!$emailExist) {

          // If email or password provided does not match
          $passwordReset['message'] = "Email address provided does not exist";
          $passwordReset['status'] = '401';
      }

      if ($emailExist) {

            $code = str_random(7);

            User::whereEmail($email)->update(['remember_token' => $code]);

            $subject = 'Password reset';

            $body = "Hi,
            Click on the link below to reset your password
            http://localhost:8000/api/v1/auth/password_reset?email=$email&code=$code
            ";

            $sendMail = mail($email, $subject, $body , 'noreply@cotenant.com');

            if ($sendMail) {

                $passwordReset['message'] = "A link for password has been sent to your email address.";
                $passwordReset['status'] = '200';

            }

      }

      return $passwordReset;

  }

  //
  // public function changePassword($data)
  // {
  //
  //     User::where('email', $data['email'])->where('password_reset' , $data['code'])->update(['password' => ]);
  //
  // }

}

?>
