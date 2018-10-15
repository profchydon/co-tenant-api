<?php

namespace App\Api\v1\Repositories;

use App\Transaction;
use App\Accept;
use App\Cotenant;
use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;

/**
 *
 */
class TransactionRepository
{
    /**
     * Create a Transaction
     *
     * @param object $request
     *
     * @return object $request
     *
     */
    public function create($request)
    {

      // Logged in user
      $user = Auth::user();

      //Fetch details of the tenant making the transaction
      $tenant = Cotenant::where('cotenants.user_id' , $user->id)->first();

      // Get the duration of rent the tenant chooses to pay for
      $duration = $tenant->duration;

      // Get current date as date the transaction was made
      $date_paid = Carbon::now('Africa/Lagos');
      $date = Carbon::now('Africa/Lagos');

      // Add 30days to current date as date for next payment
      $date_of_next_payment = $date->addDays(30);

      // Add one year to the current date as the expiry date of the transaction
      $expiry_date = Carbon::now('Africa/Lagos')->addYear($duration);

      // Number of times remaining for a debit
      $count = ($duration * 12) - 1;

      // Get the id of the accept
      $fetchAccept = Accept::find($request->accept_id);

      // Get id of tenant who accepted to pay for the property
      $cotenant_id = $fetchAccept->cotenant_id;

      // Get amount of the property
      $amount = $fetchAccept->amount;

      // Begin a database transaction to create a transaction
      DB::beginTransaction();

      // Create the transaction
      $transaction = Transaction::create([
        'accept_id' => $request->accept_id,
        'cotenant_id' => $cotenant_id,
        'email' =>  $user->email,
        'amount' => $amount,
        'date_of_next_payment' => $date_of_next_payment,
        'paystack_auth_code' => $request->paystack_auth_code,
        'date_paid' => $date_paid,
        'expiry_date' => $expiry_date,
        'count' => $count,
      ]);

      if (!$transaction) {

        // If creation of the transaction fails, roll back the database to its initial state
        DB::rollback();

      }else {

        // Update the accept record for
        $fetchAccept->update(['date_paid'=> $date , 'status' => 'finalized']);

        // If creation of the transaction is successful, then commit transaction
        DB::commit();

        // return the transaction created
        return $transaction;

      }

    }

    /**
     * Create all Transaction existing in the database
     *
     * @return object $transactions
     *
     */
    public function transactions()
    {
      // Fetch all transactions existing in the database
      $transactions = Transaction::all();

      // return list of transactions;
      return $transactions;

    }

    /**
     * Fetch a Transaction
     *
     * @param int $id
     *
     * @return object $transaction
     *
     */
    public function fetchATransaction($id)
    {
      // Fetch transaction with $id from database
      $transaction = Transaction::findOrfail($id);

      // return transaction
      return $transactions;

    }

    /**
     * Update a Transaction
     *
     * @param int $id
     * @param object $request
     *
     * @return object $transaction
     *
     */
    public function updateTransaction($id, $request)
    {
        // Fetch transaction with $id from database
        $transactions = Transaction::findOrfail($id);

        // Update transaction details
        $transaction->update($request->all());

        // return transaction
        return $transaction;

    }

}

?>
