<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Verification;
use App\Api\v1\Repositories\VerificationRepository;
use App\Api\v1\Repositories\UserRepository;

class VerificationController extends Controller
{
    /**
     * The Verification
     *
     * @var object
     */
    private $verification;

    /**
     * The User
     *
     * @var object
     */
    private $user;


    /**
     * Class constructor
     */
    public function __construct(VerificationRepository $verification , UserRepository $user)
    {
        // Inject VeriRepository Class into VerificationController
        $this->verification = $verification;
        $this->user = $user;
    }

    /**
     * Create a  new Verification
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {

      // Generate a random code
      $code = rand(10000 , 99999);

        try {

            // Call the create method of VerificationRepository
            $verification = $this->verification->create($request , $code);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 200,
                "message" => "Ok",
                "data" => $verification
            ];

            // return the custom in JSON format
            return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom response
          $response = [
              "success" => false,
              "status" => 502,
          ];

          // return the custom in JSON format
          return response()->json($response);

        }

    }

    /**
     * Fetch a Verification
     *
     * @param string $email
     *
     * @return JSON
     *
     */
    public function fetchAVerification($email)
    {

        try {

          // Call the fetchAVerification method of VerificationRepository
          $user = $this->verification->fetchAVerification($email);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $user
          ];

          // return the custom in JSON format
          return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom response
          $response = [
              "success" => false,
              "status" => 502,
          ];

          // return the custom in JSON format
          return response()->json($response);
        }

    }

    /**
     * Update a Verification
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function updateVerification(Request $request)
    {

      // Generate a random code for verification
      $code = rand(1000 , 9999);
      $code = (int)$code;

      // Call the updateVerification method of VerificationRepository
      $verification = $this->verification->updateVerification($request->email, $code);

      if ($verification == "Email address not found") {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 409,
              "message" => "Email address not found",
              "data" => []
          ];

      }else {

        // Fetch the updated data from the verification table
        $verification = $this->verification->checkEmailExist($request->email);

        $user = $this->user->fetchAUserUsingEmail($request->email);

        $data['verification'] = $verification;
        $data['user'] = $user;

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $data
        ];

      }

      // return the custom in JSON format
      return response()->json($response);

  }

    public function verifyUser(Request $request)
    {

      $verification = $this->verification->verifyUser($request->email, $request->code);

      $user = $this->user->fetchAUserUsingEmail($request->email);

      if ($verification == "Oops!!! Verification code does not match") {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Verification code does not match",
              "data" => NULL
          ];

      }elseif ($verification == "Sorry..No record found attached to this email") {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Sorry..No record found attached to this email",
              "data" => NULL
          ];

      }else {

          $data['verification'] = $verification;
          $data['user'] = $user;

          // Update the active in the user table to 1, to indicate user has been verified
          $updateUserActive = $this->verification->updateUserActive($request->email);

          // Delete the verification details from database since verification is successful
          $deleteVerifiedDetail = $this->verification->deleteVerifiredRecord($request->email, $request->code);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Verification successful",
              "data" => $data
          ];

      }

      // return the custom in JSON format
      return response()->json($response);

    }

}

?>
