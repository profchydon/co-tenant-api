<?php

namespace App\Http\Repositories;

use App\Verification;
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
        $verification = Verification::whereEmail($email)->first();

        if ($verification) {

            $verification->where('email', '=', $email)->update(['code' => $code]);

        }

        return $verification;
    }


}



 ?>
