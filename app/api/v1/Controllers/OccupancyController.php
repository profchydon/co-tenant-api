<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Api\v1\Repositories\OccupancyRepository;

class OccupancyController extends Controller
{
    /**
     * The Occupancy
     *
     * @var object
     */
    private $occupancy;


    /**
     * Class constructor
     */
    public function __construct(OccupancyRepository $occupancy)
    {
        // Inject occupancyRepository Class into occupancyController
        $this->occupancy = $occupancy;
        $this->middleware('auth');
    }

    /**
     * Create a  new occupancy
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {
        try {

            // Call the create method of occupancyRepository
            $occupancy = $this->occupancy->create($request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 201,
                "message" => "Occupancy successfully created",
                "data" => $occupancy
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
     * Fetch all existing occupancies
     *
     * @return JSON
     */
    public function occupancies ()
    {
      try {

        // Call the occupancys method of occupancyRepository
        $occupancies = $this->occupancy->occupancies();

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $occupancies
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
     * Fetch a Occupancy
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchAOccupancy($id)
    {

        try {

          // Call the fetchAOccupancy method of OccupancyRepository
          $occupancy = $this->occupancy->fetchAOccupancy($id);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $occupancy
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
     * Update a Occupancy
     *
     * @param int $id
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function updateOccupancy($id , Request $request)
    {

      try {

        // Call the updateOccupancy method of OccupancyRepository
        $occupancy = $this->occupancy->updateOccupancy($id, $request);

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $occupancy
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
