<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Interest;
use App\Api\v1\Repositories\InterestRepository;
use App\Api\v1\Repositories\AdminRepository;
use App\Api\v1\Repositories\VerificationRepository;

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
     * The Verification
     *
     * @var object
     */
    private $verification;

    /**
     * Class constructor
     */
    public function __construct(AdminRepository $admin, InterestRepository $interest, VerificationRepository $verification)
    {
        // Inject InterestRepository Class into InterestController
        $this->interest = $interest;
        $this->verification = $verification;
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

      $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

      if ($isAdmin) {

        // Call the create method of UserRepository
        $admin = $this->admin->create($request);

        if ($admin) {

            // Generate a random code for verification
            $code = rand(1000 , 9999);
            $code = (int)$code;

            // Send verification code here
            // Code goes Here

            // Save verification code and email to verification table
            $verification = $this->verification->create($request, $code);

        }

        $data['user'] = $admin;
        $data['verification'] = $verification;

        // Create a custom array as response
        $response = [
            "status" => "successful",
            "code" => 201,
            "message" => "Admin was successfully created",
            "data" => $data
        ];

      }elseif (!$isAdmin) {

        // Create a custom array as response
        $response = [
            "status" => "failed",
            "code" => 404,
            "message" => "Unauthorized. Only admins can perform this action",
            "data" => NULL
        ];

      }
      else {

        // Create a custom array as response
        $response = [
            "status" => failed,
            "code" => 404,
            "message" => "Oops! There was an error. Please try again",
            "data" => NULL
        ];

      }

      // return the custom in JSON format
      return response()->json($response);

    }

    public function matchTenantToProperty(Request $request)
    {
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

            $matchTenant = $this->admin->matchTenantToProperty($request);

            // Create a custom array as response
            $response = [
                "status" => "successful",
                "code" => 200,
                "message" => "Ok",
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
            "status" => "failed",
            "code" => 404,
            "message" => "Unauthorized. Only admins are allowed to make this action",
            "data" => {}
        ];

      }else {

          // Fetch the user with email
          $cotenantRecords = $this->admin->cotenantRecords($request);

          if ($cotenantRecords == "User does not exist") {

            $response = [
                "status" => "failed",
                "code" => 409,
                "message" => $cotenantRecords,
                "data" => {}
            ];

          }else {

            $response = [
                "status" => "success",
                "code" => 200,
                "message" => "Ok",
                "data" => $cotenantRecords
            ];

          }

      }

      // return the custom in JSON format
      return response()->json($response);



    }

}

?>
