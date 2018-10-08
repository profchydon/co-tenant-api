<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cotenant;
use App\Http\Repositories\CotenantRepository;

class CotenantController extends Controller
{

    /**
     * The Tenant
     *
     * @var object
     */
    private $tenant;


    /**
     * Class constructor
     */
    public function __construct(CotenantRepository $tenant)
    {
        // Inject TenantRepository Class into TenantController
        $this->tenant = $tenant;
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

            // Call the create method of TenantRepository
            $tenant = $this->tenant->create($request);

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
                "data" => $tenant
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
     * Fetch all existing Tenants
     *
     * @return JSON
     */
    public function tenants ()
    {
      try {

        // Call the Tenants method of TenantRepository
        $tenants = $this->tenant->tenants();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $tenants
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
     * Fetch a Tenant
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchATenant($id)
    {

        try {

          // Call the fetchATenant method of TenantRepository
          $tenant = $this->tenant->fetchATenant($id);

          // Check size of $tenant array to determine if there is a resource.
          if (sizeof($tenant) == 0) {

              $tenant = "No data found: Tenant does not exist";


          }

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $tenant
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

    public function updateTenant($id , Request $request)
    {

      try {

        // Call the updateTenant method of TenantRepository
        $tenant = $this->tenant->updateTenant($id, $request);

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $tenant
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
