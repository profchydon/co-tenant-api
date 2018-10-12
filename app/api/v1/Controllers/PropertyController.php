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

                $property = "Unauthorized to create a property. Only admins are allowed to create properties";
                $status = 401;

            }else {

              // Call the create method of PropertyRepository
              $property = $this->property->create($request);
              $status = 201;

            }

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => $status,
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

          $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

          if (!$isAdmin) {

              $property = "Unauthorized to update a property. Only admins are allowed to do so";
              $status = 401;

          }else {

            // Call the updateProperty method of PropertyRepository
            $property = $this->property->updateProperty($id, $request);
            $status = 201;

          }

          // Create a custom response
          $response = [
              "success" => true,
              "status" => $status,
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
