<?php

namespace App\Api\v1\Repositories;

use App\Interest;
use App\Property;
use Illuminate\Http\Request;
use App\Api\v1\Repositories\PropertyRepository;
use DB;

/**
 *
 */
class InterestRepository
{

    public function create($request)
    {

      DB::beginTransaction();

      $interestExist = Interest::where('property_id' , $request->property_id)->where('cotenant_id', $request->cotenant_id)->get();

      if (count($interestExist) == 0) {

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

      }elseif (count($interestExist) > 0) {

          $interest = "You have already declared interest for this property";
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


    public function allInterestsForTenant($cotenant_id)
    {
      // Fetch interest with $id from database
      $interests = Interest::where('cotenant_id' , $cotenant_id)->get();

      $i = 0;

      foreach ($interests as $key => $interest) {

          $property[$i] = Property::findOrfail($interest->property_id);
          $i++;
      }

      // return interest
      return $property;

    }

    /**
     * Fetch all Interests for a tenant
     *
     * @param int $id
     *
     * @return object $interest
     *
     */
    public function allInterestForTenant($id)
    {
      // Fetch interest with $id from database
      $interest = Interest::where('cotenant_id' , $id)->get();

      // return interest
      return $interest;

    }



    /**
     * Delete an Interest for a tenant
     *
     * @param int $id
     *
     * @return object $interest
     *
     */
    public function delete($request)
    {

      DB::beginTransaction();

      $interest = $this->fetchAInterest($request->id);
      $interest = $interest->delete();

      if (!$interest) {
        DB::rollback();
      }else {
        DB::commit();
        return $interest;
      }

    }

}

?>
