<?php

namespace App\Api\v1\Repositories;

use App\Occupancy;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class OccupancyRepository
{

    public function create($request)
    {

      DB::beginTransaction();

      $occupancy = Occupancy::create([
        'property_id' => $request->property_id,
        'number_of_rooms' => $request->number_of_rooms,
        'frequency' => $request->frequency,
      ]);

      if (!$occupancy) {
        DB::rollback();
      }else {
        DB::commit();
        return $occupancy;
      }

    }

    /**
     * Create all occupancys existing in the database
     *
     * @return object $occupancy
     *
     */
    public function occupancies()
    {
      // Fetch all occupancies existing in the database
      $occupancies = Occupancy::all();

      // return list of Occupancies;
      return $occupancies;

    }

    /**
     * Fetch a occupancy
     *
     * @param int $id
     *
     * @return object $occupancy
     *
     */
    public function fetchAOccupancy($id)
    {
      // Fetch Occupancy with $id from database
      $occupancy = Occupancy::findOrfail($id);

      // return Occupancy
      return $occupancy;

    }

    /**
     * Update a occupancy
     *
     * @param int $id
     * @param object $request
     *
     * @return object $occupancy
     *
     */
    public function updateOccupancy ($id, $request)
    {
        // Fetch Occupancy with $id from database
        $occupancy = Occupancy::findOrfail($id);

        // Update Occupancy details
        $occupancy->update($request->all());

        // return occupancy
        return $occupancy;

    }

}

?>
