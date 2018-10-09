<?php

namespace App\Http\Repositories;

use App\Interest;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class InterestRepository
{

    public function create($request)
    {

      DB::beginTransaction();

      $interest = Interest::create([
        'property_id' => $request->property_id,
        'cotenant_id' => $request->cotenant_id,
      ]);

      if (!$interest) {
        DB::rollback();
      }else {
        DB::commit();
        return $interest;
      }

    }

    /**
     * Create all Interests existing in the database
     *
     * @return object $interest
     *
     */
    public function interests()
    {
      // Fetch all interests existing in the database
      $interests = Interest::all();

      // return list of users;
      return $interests;

    }

    /**
     * Fetch a Interest
     *
     * @param int $id
     *
     * @return object $interest
     *
     */
    public function fetchAInterest($id)
    {
      // Fetch interest with $id from database
      $interest = Interest::findOrfail($id);

      // return interest
      return $interest;

    }

}

?>
