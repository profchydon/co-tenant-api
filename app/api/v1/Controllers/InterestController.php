<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Interest;
use App\Api\v1\Repositories\InterestRepository;

class InterestController extends Controller
{
    /**
     * The Interest
     *
     * @var object
     */
    private $interest;

    /**
     * Class constructor
     */
    public function __construct(InterestRepository $interest)
    {
        // Inject InterestRepository Class into InterestController
        $this->interest = $interest;
        $this->middleware('auth');
    }

    /**
     * Create a  new Interest
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {
        try {

            // Call the create method of InterestRepository
            $interest = $this->interest->create($request);

            if ($interest == "You have already declared interest for this property") {

              // Create a custom array as response
              $response = [
                  "status" => "failed",
                  "code" => 409,
                  "message" => $interest,
                  "data" => NULL
              ];

            }else {

              // Create a custom array as response
              $response = [
                  "status" => "success",
                  "code" => 201,
                  "message" => "Interest created successfully",
                  "data" => $interest
              ];

            }

            // return the custom in JSON format
            return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => NULL
          ];

          // return the custom in JSON format
          return response()->json($response);

        }

    }


    /**
     * Delete an Interest
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function delete (Request $request)
    {
        try {

            // Call the create method of InterestRepository
            $interest = $this->interest->delete($request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 200,
                "message" => "Interest deleted successfully",
                "data" => $interest
            ];


            // return the custom in JSON format
            return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => NULL
          ];

          // return the custom in JSON format
          return response()->json($response);

        }

    }


    /**
     * Fetch all existing Interest
     *
     * @return JSON
     */
    public function interests ()
    {
      try {

        // Call the interests method of InterestRepository
        $interests = $this->interest->interests();

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $interests
        ];

        // return the custom in JSON format
        return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom array as response
        $response = [
            "status" => "failed",
            "code" => 404,
            "message" => "Error! Sorry server could not process this request",
            "data" => NULL
        ];

        // return the custom in JSON format
        return response()->json($response);

      }

    }


    /**
     * Fetch a User
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchAInterest($id)
    {

        try {

          // Call the fetchAInterest method of InterestRepository
          $interest = $this->interest->fetchAInterest($id);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $interest
          ];


          // return the custom in JSON format
          return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => NULL
          ];

          // return the custom in JSON format
          return response()->json($response);
        }
    }

    /**
     * Fetch a User
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function allInterestsForTenant($id)
    {

        try {

          // Call the fetchAInterest method of InterestRepository
          $interest = $this->interest->allInterestsForTenant($id);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $interest
          ];


          // return the custom in JSON format
          return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => NULL
          ];

          // return the custom in JSON format
          return response()->json($response);
        }
    }


}

?>
