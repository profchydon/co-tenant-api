<?php

namespace App\Http\Repositories;

use App\Transaction;
use App\Accept;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use DateTimeZone;

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

      // Begin a database transaction to create a transaction
      DB::beginTransaction();

      $duration = 1;
      $date = Carbon::now('Africa/Lagos');
      $expiry_date = Carbon::now('Africa/Lagos')->addYear($duration);
      $count = ($duration * 12) - 1;

      // Create the transaction
      $transaction = Transaction::create([
        'accepted_id' => $request->accepted_id,
        'cotenant_id' => $request->cotenant_id,
        'amount' => $request->amount,
        'date' => $date,
        'expiry_date' => $expiry_date,
        'count' => $count,
      ]);

      if (!$transaction) {

        // If creation of the transaction fails, roll back the database to its initial state
        DB::rollback();

      }else {

        $updateAccept = Accept::find($request->accepted_id);

        $updateAccept->update(['date_paid'=> $date , 'status' => 'finalized']);

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
