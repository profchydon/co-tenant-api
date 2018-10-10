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

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
                "data" => $interest
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
     * Fetch all existing Interest
     *
     * @return JSON
     */
    public function interests ()
    {
      try {

        // Call the interests method of InterestRepository
        $interests = $this->interest->interests();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $interests,
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
          $interests = $this->interest->fetchAInterest($id);

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $interests
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
