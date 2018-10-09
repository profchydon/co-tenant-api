<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accept;
use App\Http\Repositories\AcceptRepository;

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
                "success" => true,
                "status" => 201,
                "data" => $accept
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
     * Fetch all existing accepts
     *
     * @return JSON
     */
    public function accepts ()
    {
      try {

        // Call the accepts method of AcceptRepository
        $accept = $this->accept->accepts();

        // Create a custom response
        $response = [
            "success" => true,
            "status" => 200,
            "data" => $accept
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

          // Create a custom response
          $response = [
              "success" => true,
              "status" => 200,
              "data" => $accept
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
