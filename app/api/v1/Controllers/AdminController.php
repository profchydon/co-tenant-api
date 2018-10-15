<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Interest;
use App\Api\v1\Repositories\InterestRepository;
use App\Api\v1\Repositories\AdminRepository;

class AdminController extends Controller
{

    /**
     * The Interest
     *
     * @var object
     */
    private $interest;

    /**
     * The Admin
     *
     * @var object
     */
    private $admin;


    /**
     * Class constructor
     */
    public function __construct(AdminRepository $admin, InterestRepository $interest)
    {
        // Inject InterestRepository Class into InterestController
        $this->interest = $interest;
        $this->admin = $admin;
        $this->middleware('auth');

    }

    /**
     * Create a  new User
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

            if ($isAdmin) {

              // Call the create method of UserRepository
              $admin = $this->admin->create($request);

              if ($admin) {

                  // Generate a random code for verification
                  $code = rand(10000 , 99999);

                  // Send verification code here
                  // Code goes Here

                  // Save verification code and email to verification table
                  $verification = $this->verification->create($request, $code);

              }

              $data['user'] = $admin;
              $data['verification'] = $verification;

              // Create a custom array as response
              $response = [
                  "success" => true,
                  "status" => 201,
                  "data" => $data
              ];

            }

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

    public function matchTenantToProperty(Request $request)
    {
        $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

        if (!$isAdmin) {

          // Create a custom array as response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => "Unauthorized. Only admins are authorized to make this action"
          ];

        }else {

            $matchTenant = $this->admin->matchTenantToProperty($request);

            $response = [
                "success" => true,
                "status" => 201,
                "data" => $matchTenant
            ];

        }

        // return the custom in JSON format
        return response()->json($response);
    }


    public function cotenantRecords(Request $request)
    {

      $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

      if (!$isAdmin) {

        // Create a custom array as response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => "Unauthorized. Only admins are authorized to make this action"
        ];

      }else {

          // Fetch the user with email
          $cotenantRecords = $this->admin->cotenantRecords($request);

          if ($cotenantRecords == "User does not exist") {

              $response = [
                  "success" => true,
                  "status" => 401,
                  "data" => $cotenantRecords
              ];

          }else {

              $response = [
                  "success" => true,
                  "status" => 201,
                  "data" => $cotenantRecords
              ];

          }

      }

      // return the custom in JSON format
      return response()->json($response);



    }

}

?>
