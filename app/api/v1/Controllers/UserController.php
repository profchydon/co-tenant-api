<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Api\v1\Repositories\UserRepository;
use App\Api\v1\Repositories\VerificationRepository;


class UserController extends Controller
{
    /**
     * The User
     *
     * @var object
     */
    private $user;

    /**
     * The Verification
     *
     * @var object
     */
    private $verification;

    /**
     * Class constructor
     */
    public function __construct(UserRepository $user , VerificationRepository $verification)
    {
        // Inject UserRepository Class into UserController
        $this->user = $user;
        $this->verification = $verification;
        $this->middleware('auth', ['except' => ['create']]);

        $auth = Auth::user();

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

            // Call the create method of UserRepository
            $user = $this->user->create($request);

            if ($user) {

                // Generate a random code for verification
                $code = rand(10000 , 99999);

                // Send verification code here
                // Code goes Here

                // Save verification code and email to verification table
                $verification = $this->verification->create($request, $code);

            }

            $data['user'] = $user;
            $data['verification'] = $verification;

            // Create a custom array as response
            $response = [
                "success" => true,
                "status" => 201,
                "data" => $data
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
     * Fetch all existing Users
     *
     * @return JSON
     */
    public function users ()
    {

      try {

        // Call the users method of UserRepository
        $user = $this->user->users();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $user
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
    public function fetchAUser($id)
    {

        try {

          // Call the fetchAUser method of UserRepository
          $user = $this->user->fetchAUser($id);

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $user
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
     * Update a User
     *
     * @param int $id
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function updateUser(Request $request)
    {

      try {

        // Call the updateUser method of UserRepository
        $user = $this->user->updateUser($request);

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $user
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

    public function sendVerificationMail(){

      $user = Auth::user();

      $mail = $this->user->sendVerificationMail($user);

      return $mail;

    }

}

?>
