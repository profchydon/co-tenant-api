<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\Api\v1\Repositories\PropertyRepository;
use App\Api\v1\Repositories\AdminRepository;

class PropertyController extends Controller
{
    /**
     * The Property
     *
     * @var object
     */
    private $property;

    /**
     * The Admin
     *
     * @var object
     */
    private $admin;


    /**
     * Class constructor
     */
    public function __construct(PropertyRepository $property, AdminRepository $admin)
    {
        // Inject PropertyRepository Class into PropertyController
        $this->property = $property;
        $this->admin = $admin;
        $this->middleware('auth');
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

            $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

            if (!$isAdmin) {

              // Create a custom array as response
              $response = [
                  "status" => "failed",
                  "code" => 404,
                  "message" => "Unauthorized. Only admins can perform this action",
                  "data" => NULL
              ];


            }else {

              // Call the create method of PropertyRepository
              $property = $this->property->create($request);

              // Create a custom array as response
              $response = [
                  "status" => "success",
                  "code" => 201,
                  "message" => "Property was successfully created",
                  "data" => $property
              ];

            }

            // return the custom in JSON format
            return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => failed,
              "code" => 404,
              "message" => "Oops! There was an error. Please try again",
              "data" => NULL
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
        $properties = $this->property->properties();

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $properties
        ];

        // return the custom in JSON format
        return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom array as response
        $response = [
            "status" => failed,
            "code" => 404,
            "message" => "Oops! There was an error. Please try again",
            "data" => NULL
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

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $property
          ];
          // return the custom in JSON format
          return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => failed,
              "code" => 404,
              "message" => "Oops! There was an error. Please try again",
              "data" => NULL
          ];

          // return the custom in JSON format
          return response()->json($response);
        }

    }

    public function updateProperty($id , Request $request)
    {

      try {

          $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

          if (!$isAdmin) {

            // Create a custom array as response
            $response = [
                "status" => "failed",
                "code" => 404,
                "message" => "Unauthorized. Only admins can perform this action",
                "data" => NULL
            ];

          }else {

            // Call the updateProperty method of PropertyRepository
            $property = $this->property->updateProperty($id, $request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 200,
                "message" => "Update successful",
                "data" => $property
            ];

          }

          // return the custom in JSON format
          return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom array as response
        $response = [
            "status" => failed,
            "code" => 404,
            "message" => "Oops! There was an error. Please try again",
            "data" => NULL
        ];


        // return the custom in JSON format
        return response()->json($response);
      }

    }

    public function propertyFiltered(Request $request)
    {
        $properties = $this->property->propertyFiltered($request);

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Search successful",
            "data" => $properties
        ];

        // return the custom in JSON format
        return response()->json($response);
    }

}

?>
