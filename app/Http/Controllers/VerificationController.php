<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Verification;
use App\Http\Repositories\VerificationRepository;

class VerificationController extends Controller
{
    /**
     * The Verification
     *
     * @var object
     */
    private $verification;


    /**
     * Class constructor
     */
    public function __construct(VerificationRepository $verification)
    {
        // Inject VeriRepository Class into VerificationController
        $this->verification = $verification;
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
      $code = str_random(7);

        try {

            // Call the create method of VerificationRepository
            $verification = $this->verification->create($request , $code);

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
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

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
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

      // Generate a random code
      $code = str_random(7);

      try {

        // Call the updateVerification method of VerificationRepository
        $verification = $this->verification->updateVerification($request->email , $code);

        if ($verification) {

          // Fetch the updated data from the verification table
          $verification = Verification::whereEmail($request->email)->first();

        }else {

          $verification = "Email does not exist";

        }

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
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

}

?>
