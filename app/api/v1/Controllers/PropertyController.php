<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Api\v1\Repositories\PropertyRepository;

class PropertyController extends Controller
{
    /**
     * The Property
     *
     * @var object
     */
    private $property;


    /**
     * Class constructor
     */
    public function __construct(PropertyRepository $property)
    {
        // Inject PropertyRepository Class into PropertyController
        $this->property = $property;
    }

    /**
     * Create a  new Property
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {
        try {

            // Call the create method of PropertyRepository
            $property = $this->property->create($request);

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
                "data" => $property
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
     * Fetch all existing Properties
     *
     * @return JSON
     */
    public function properties ()
    {
      try {

        // Call the Properties method of PropertyRepository
        $property = $this->property->properties();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $property
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
     * Fetch a Property
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchAProperty($id)
    {

        try {

          // Call the fetchAProperty method of PropertyRepository
          $property = $this->property->fetchAProperty($id);

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $property
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

    public function updateProperty($id , Request $request)
    {

      try {

        // Call the updateProperty method of PropertyRepository
        $property = $this->property->updateProperty($id, $request);

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $property
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
