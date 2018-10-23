<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Cotenant;
use App\Api\v1\Repositories\CotenantRepository;
use App\Api\v1\Repositories\AcceptRepository;

class CotenantController extends Controller
{

    /**
     * The Tenant
     *
     * @var object
     */
    private $cotenant;

    /**
     * The Accept
     *
     * @var object
     */
    private $accept;


    /**
     * Class constructor
     */
    public function __construct(CotenantRepository $cotenant , AcceptRepository $accept)
    {
        // Inject CoTenantRepository Class into CoTenantController
        $this->cotenant = $cotenant;
        $this->accept = $accept;
        $this->middleware('auth', ['except' => ['create']]);
    }

    /**
     * Create a  new Tenant
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {
        try {

            // Call the create method of CoTenantRepository
            $cotenant = $this->cotenant->create($request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 201,
                "message" => "Tenant created successfully",
                "data" => $cotenant
            ];

            // return the custom in JSON format
            return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => []
          ];

          // return the custom in JSON format
          return response()->json($response);

        }

    }


    /**
     * Fetch all existing Tenants
     *
     * @return JSON
     */
    public function cotenants ()
    {
      try {

        // Call the Tenants method of CoTenantRepository
        $cotenants = $this->cotenant->cotenants();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $cotenants
        ];

        // return the custom in JSON format
        return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom array as response
        $response = [
            "status" => "failed",
            "code" => 404,
            "message" => "Error! Sorry server could not process this request",
            "data" => []
        ];

        // return the custom in JSON format
        return response()->json($response);

      }

    }


    /**
     * Fetch a Tenant
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchACoTenant($id)
    {

        try {

          // Call the fetchACoTenant method of CoTenantRepository
          $cotenant = $this->cotenant->fetchACoTenant($id);

          // Check size of $tenant array to determine if there is a resource.
          if (sizeof($cotenant) == 0) {

              $cotenant = "No data found: Tenant does not exist";


          }

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $cotenant
          ];

          // return the custom in JSON format
          return response()->json($response);

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => []
          ];

          // return the custom in JSON format
          return response()->json($response);
        }

    }

    public function updateCoTenant(Request $request)
    {

      try {

        // Call the updateTenant method of TenantRepository
        $cotenant = $this->cotenant->updateCoTenant($request);

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $cotenant
        ];

        // return the custom in JSON format
        return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom array as response
        $response = [
            "status" => "failed",
            "code" => 404,
            "message" => "Error! Sorry server could not process this request",
            "data" => []
        ];

        // return the custom in JSON format
        return response()->json($response);
      }

    }

    public function allAccepts(Request $request)
    {

        try {

            $allAccepts = $this->accept->allAcceptsForATenant($request);

            // Create a custom response
            $response = [
                "success" => true,
                "status" => 200,
                "data" => $allAccepts
            ];

        } catch (\Exception $e) {

          // Create a custom array as response
          $response = [
              "status" => "failed",
              "code" => 404,
              "message" => "Error! Sorry server could not process this request",
              "data" => []
          ];

        }

        // return the custom in JSON format
        return response()->json($response);

    }

}

?>
