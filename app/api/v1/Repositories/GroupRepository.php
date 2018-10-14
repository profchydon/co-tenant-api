<?php

namespace App\Api\v1\Repositories;

use App\Group;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class GroupRepository
{

    /**
   * Create a  new Group
   *
   * @param object $request
   *
   * @return object $group
   *
   */
    public function create($request)
    {

      // Begin databse transaction
      DB::beginTransaction();

      // Create group
      $group = Group::create([
        'user_type' => $request->user_type,
      ]);

      if (!$group) {

        // If the instance of group is not created, roll back database to its initial state
        DB::rollback();

      }else {

        // If the instance of group is created, commit the transaction
        DB::commit();

        return $group;
      }


    }

    /**
   * Fetch all existing groups
   *
   * @return object $groups
   *
   */
    public function groups()
    {
      // Fetch all groups
      $groups = Group::all();
      return $groups;

    }



}


?>
