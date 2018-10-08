<?php

namespace App\Http\Repositories;

use App\Group;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class GroupRepository
{

  public function create($request)
  {

    DB::beginTransaction();
    $group = Group::create([
      'user_type' => $request->user_type,
    ]);

    if (!$group) {
      DB::rollback();
    }else {
      DB::commit();
      return $group;
    }

  }

  public function groups()
  {
    $groups = Group::all();
    return $groups;

  }



}


?>
