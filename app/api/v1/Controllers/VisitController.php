<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use App\Api\v1\Repositories\VisitRepository;

class VisitController extends Controller
{
    /**
     * The visit
     *
     * @var object
     */
    private $visit;


    /**
     * Class constructor
     */
    public function __construct(VisitRepository $visit)
    {
        // Inject VisitRepository Class into VisitController
        $this->visit = $visit;
        $this->middleware('auth');
    }

    public function create (Request $request)
    {

      try {

          // Call the create method of VisitRepository
          $visit = $this->visit->create($request);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $visit
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

    public function visits ()
    {
        $visits = $this->visit->visits();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $visits
        ];

        // return the custom in JSON format
        return response()->json($response);
    }


    public function updateVisit(Request $request)
    {

        try {

            $updateVisit = $this->visit->updateVisit($request);

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
                "data" => $updateVisit
            ];

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
