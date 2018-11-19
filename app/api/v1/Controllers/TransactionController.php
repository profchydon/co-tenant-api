<?php

namespace App\Api\v1\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Api\v1\Repositories\TransactionRepository;

class TransactionController extends Controller
{
    /**
     * The Transaction
     *
     * @var object
     */
    private $transaction;


    /**
     * Class constructor
     */
    public function __construct(TransactionRepository $transaction)
    {
        // Inject TransactionRepository Class into TransactionController
        $this->transaction = $transaction;
        $this->middleware('auth');
    }

    /**
     * Create a  new Transaction
     *
     * @param object $request
     *
     * @return JSON
     *
     */
    public function create (Request $request)
    {
        try {

            // Call the create method of TransactionRepository
            $transaction = $this->transaction->create($request);

            // Create a custom array as response
            $response = [
                "status" => "success",
                "code" => 201,
                "message" => "Transaction successfully created",
                "data" => $transaction
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
     * Fetch all existing Transaction
     *
     * @return JSON
     */
    public function transactions ()
    {
      try {

        // Call the transactions method of TransactionRepository
        $transactions = $this->transaction->transactions();

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $transactions
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
     * Fetch a Transaction
     *
     * @param int $id
     *
     * @return JSON
     *
     */
    public function fetchATransaction($id)
    {

        try {

          // Call the fetchATransaction method of TransactionRepository
          $transaction = $this->transaction->fetchATransaction($id);

          // Create a custom array as response
          $response = [
              "status" => "success",
              "code" => 200,
              "message" => "Ok",
              "data" => $transaction
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

    public function updateTransaction($id , Request $request)
    {

      try {

        // Call the updateTransaction method of TransactionRepository
        $transaction = $this->transaction->updateTransaction($id, $request);

        // Create a custom array as response
        $response = [
            "status" => "success",
            "code" => 200,
            "message" => "Ok",
            "data" => $transaction
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
