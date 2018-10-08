<?php

namespace App\Http\Repositories;

use App\Tenant;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class TenantRepository
{
    /**
     * Create a Tenant
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

      // Create the tenant
      $tenant = Tenant::create([
        'user_id' => 1,
        'co_gender' => $request->co_gender,
        'religion' => $request->religion,
        'co_religion' => $request->co_religion,
        'smoke' => $request->smoke,
        'co_smoke' => $request->co_smoke,
        'disabled' => $request->disabled,
        'co_disabled' => $request->co_disabled,
        'location_1' => $request->location_1,
        'location_2' => $request->location_2,
        'work' => $request->work,
        'salary' => $request->salary,
        'rent' => $request->rent,
        'duration' => $request->duration,
      ]);

      if (!$tenant) {

        // If creation of the tenant fails, roll back the database to its initial state
        DB::rollback();

      }else {

        // If creation of the tenant is successful, then commit transaction
        DB::commit();

        // return the tenant created
        return $tenant;

      }

    }

    /**
     * Fetch all Tenant existing in the database
     *
     * @return object $tenant
     *
     */
    public function tenants()
    {
      // Fetch all tenants existing in the database
      $tenants = Tenant::all();

      // return list of properties;
      return $tenants;

    }

    /**
     * Fetch a Tenant
     *
     * @param int $id
     *
     * @return object $tenant
     *
     */
     public function fetchATenant($id)
     {
        $tenant = Tenant::where('tenants.id', $id)->leftJoin('users', 'users.id', '=', 'tenants.user_id')->select('user.email','tenants.co_gender')->get();
        return $tenant;
      }


    /**
     * Update a Tenant
     *
     * @param int $id
     * @param object $request
     *
     * @return object $tenant
     *
     */
    public function updateTenant($id, $request)
    {
        // Fetch tenant with $id from database
        $tenant = Tenant::findOrfail($id);

        // Update tenant details
        $tenant->update($request->all());

        // return tenant
        return $tenant;

    }

}

?>
