<?php

namespace App\Api\v1\Repositories;

use App\Interest;
use App\User;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class AdminRepository
{

    public function matchTenantToProperty($request)
    {

        DB::beginTransaction();

        $matchTenant = Interest::create([
            'property_id' => $request->property_id,
            'cotenant_id' => $request->cotenant_id,
        ]);

        if (!$matchTenant) {
          DB::rollback();
        }else {
          DB::commit();
          return $matchTenant;
        }

    }


    // Check if user with api key is an admin
    public function isAdmin($api_key)
    {
      $isAdmin = User::where('api_key', $api_key)->first();

      if ($isAdmin->user_group == "admin") {
          return true;
      }else {
        return false;
      }
    }


}

?>
