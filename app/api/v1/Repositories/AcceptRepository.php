<?php

namespace App\Api\v1\Repositories;

use App\Accept;
use App\Property;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

/**
 *
 */
class AcceptRepository
{

    /**
   * Create a  new User
   *
   * @param object $request
   *
   * @return object $accept
   *
   */
    public function create($request)
    {

      // Get the current date
      $date_initiated = Carbon::now('Africa/Lagos');

      //initialize static variables
      $date_paid = "not paid";
      $status = "Unfinalized";

      // Fetch the details of the particula property
      $property = Property::whereId($request->property_id)->first();

      // Get the amount of the property
      $amount = $property->amount;

      // Begin database transaction
      DB::beginTransaction();

      // Create an Accept
      $accept = Accept::create([
        'property_id' => $request->property_id,
        'cotenant_id' => $request->cotenant_id,
        'amount' => $amount,
        'date_initiated' => $date_initiated,
        'date_paid' => $date_paid,
        'status' => $status
      ]);


      if (!$accept) {

        // If the instance of accept is not created, roll back database to its initial state
        DB::rollback();

      }else {

        // If the instance of accept is created, commit the transaction
        DB::commit();

        return $accept;
      }

    }

    /**
     * Fetch all Accepts existing in the database
     *
     * @return object $accept
     *
     */
    public function accepts()
    {
      // Fetch all accepts existing in the database
      $accepts = Accept::all();

      // return list of accepts;
      return $accepts;

    }

    public function fetchAAccept($id)
    {
        $accept = Accept::find($id);

        return $accept;
    }

    /**
     * Get all accepts for a tenant
     *
     * @param int $id
     * @param object $request
     *
     * @return object $tenant
     *
     */
    public function allAcceptsForATenant($request)
    {

        $allAccepts = Accept::where('cotenant_id' , $request->cotenant_id)->get();

        return $allAccepts;

    }

}

?>
