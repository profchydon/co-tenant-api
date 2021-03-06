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


    /**
     * Filter Property based on Tenant search
     *
     * @param object $request
     *
     * @return object $property
     *
     */
    public function propertyFiltered($request)
    {
        try {

            $location_1 = htmlentities(strip_tags(trim($request->location_1)));
            $location_2 = htmlentities(strip_tags(trim($request->location_2)));

            if (empty($location_1) && empty($location_2)) {

                return "No search parameter provided. Please provide a location";

            }
            elseif (empty($location_1)) {

                // If location 1 from user search is empty return only properies of location 2
                return $properties[$location_2] = Property::where('location' , $location_2)->get();

            }
            elseif (empty($location_2)) {

                // If location 2 from user search is empty return only properies of location 1
                return $properties[$location_1] = Property::where('location' , $location_1)->get();

            }
            else {

              $properties['location_1'] = Property::where('location' , $location_1)->get();
              $properties['location_2'] = Property::where('location' , $location_2)->get();
              return $properties;

            }

        } catch (\Exception $e) {

              return "Oops! Sorry there was an error. Please try again";

        }


    }

}

?>
