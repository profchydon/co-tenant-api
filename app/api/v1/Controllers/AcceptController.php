<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Accept;
use Auth;
use App\Api\v1\Repositories\AcceptRepository;

class AcceptController extends Controller
{
    /**
     * The accept
     *
     * @var object
     */
    private $accept;


    /**
     * Class constructor
     */
    public function __construct(AcceptRepository $accept)
    {
        // Inject AcceptRepository Class into AcceptController
        $this->accept = $accept;
        $this->middleware('auth');
    }

    /**
     * Create a  new accept
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {

        try {

            // Call the create method of AcceptRepository
            $accept = $this->accept->create($request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 201,
                "message" => "Accept created successfully",
                "data" => $accept
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
     * Fetch all existing accepts
     *
     * @return JSON
     */
    public function accepts ()
    {
      try {

        // Call the accepts method of AcceptRepository
        $accepts = $this->accept->accepts();

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $accepts
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
     * Fetch a accept
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchAAccept($id)
    {

        try {

          // Call the fetchAAccept method of AcceptRepository
          $accept = $this->accept->fetchAAccept($id);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $accept
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
