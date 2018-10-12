<?php

namespace App\Api\v1\Repositories;

use App\Verification;
use App\User;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class VerificationRepository
{

    public function create($request, $code)
    {

      DB::beginTransaction();
      $verification = Verification::create([
        'code' => $code,
        'email' => $request->email,
      ]);

      if (!$verification) {
        DB::rollback();
      }else {
        DB::commit();
        return $verification;
      }

    }

    /**
     * Fetch a Verification
     *
     * @param string $email
     *
     * @return object $verification
     *
     */
    public function fetchAVerification($email)
    {
      // Fetch verification with $email from database
      $verification = Verification::findOrfail($email);

      // return verification
      return $verification;

    }

    public function checkEmailExist($email)
    {
      return $verification = Verification::whereEmail($email)->first();
    }

    /**
     * Update a Verification code
     *
     * @param string $email
     *
     * @return string $code
     *
     */
    public function updateVerification($email, $code)
    {
        // Verify if provided email exists in database
        $verification = $this->checkEmailExist($email);

        if ($verification) {

            $verification->where('email', $email)->update(['code' => $code]);

        }

        return $verification;
    }

    public function verifyUser($email, $code)
    {

      // Verify if provided email exists in database
      $checkIfEmailExists = $this->checkEmailExist($email);

      if ($checkIfEmailExists == NULL) {

          $checkIfEmailExists = "Sorry..No record found attached to this email";

      }else {

        if ($checkIfEmailExists->code == $code) {

            $checkIfEmailExists = $checkIfEmailExists;

        }else {

            $checkIfEmailExists = "Oops!!! Verification code does not match";

        }

      }

      return $checkIfEmailExists;

    }

    public function updateUserActive($email)
    {

      $updateUserActive = User::where('email', $email)->update(['active' => 1]);

      if ($updateUserActive) {

          return true;

      }else {

          return false;

      }

    }

    public function deleteVerifiredRecord($email, $code)
    {
        $deleteDetail = Verification::whereEmail($email)->where('code' , $code)->delete();

        if ($deleteDetail) {

            return true;

        }else {

            return false;

        }
    }

}



 ?>
