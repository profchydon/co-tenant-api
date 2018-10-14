<?php

namespace App\Api\v1\Repositories;

use App\Property;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class PropertyRepository
{
    /**
     * Create a Property
     *
     * @param object $request
     *
     * @return object $request
     *
     */
    public function create($request)
    {

      // Begin a database transaction to create a property
      DB::beginTransaction();

      // Create the property
      $property = Property::create([
        'title' => $request->title,
        'image' => $request->image,
        'description' => $request->description,
        'address' => $request->address,
        'location' => $request->location,
        'amount' => $request->amount,
        'bathroom' => $request->bathroom,
        'kitchen' => $request->kitchen,
        'living_room' => $request->living_room,
        'number_of_rooms' => $request->number_of_rooms,
        'additional_details' => $request->additional_details,
        'status' => 'open',
      ]);

      if (!$property) {

        // If creation of the property fails, roll back the database to its initial state
        DB::rollback();

      }else {

        // If creation of the property is successful, then commit transaction
        DB::commit();

        // return the property created
        return $property;

      }

    }

    /**
     * Create all Properties existing in the database
     *
     * @return object $properties
     *
     */
    public function properties()
    {
      // Fetch all properties existing in the database
      $properties = Property::all();

      // return list of properties;
      return $properties;

    }

    /**
     * Fetch a Property
     *
     * @param int $id
     *
     * @return object $property
     *
     */
    public function fetchAProperty($id)
    {
      // Fetch property with $id from database
      $property = Property::findOrfail($id);

      // return property
      return $property;

    }

    /**
     * Update a Property
     *
     * @param int $id
     *
     * @param object $request
     *
     * @return object $property
     *
     */
    public function updateProperty($id, $request)
    {
        // Fetch property with $id from database
        $property = Property::findOrfail($id);

        // Update property details
        $property->update($request->all());

        // return property
        return $property;

    }

}

?>
