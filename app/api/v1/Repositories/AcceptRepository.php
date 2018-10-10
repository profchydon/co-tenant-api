<?php

namespace App\Api\v1\Repositories;

use App\Accept;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

/**
 *
 */
class AcceptRepository
{

    public function create($request)
    {

      $date_initiated = Carbon::now('Africa/Lagos');
      $date_paid = "";
      $status = "Unfinalized";

      DB::beginTransaction();

      $accept = Accept::create([
        'property_id' => $request->property_id,
        'cotenant_id' => $request->cotenant_id,
        'amount' => $request->amount,
        'date_initiated' => $date_initiated,
        'date_paid' => $date_paid,
        'status' => $status
      ]);


      if (!$accept) {
        DB::rollback();
      }else {
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

    /**
     * Fetch a accept
     *
     * @param int $id
     *
     * @return object $accept
     *
     */
    public function fetchAAccept($id)
    {
      // Fetch Accept with $id from database
      $accept = Accept::findOrfail($id);

      // return accept
      return $accept;

    }

}

?>
