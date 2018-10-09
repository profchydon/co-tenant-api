<?php

namespace App\Http\Repositories;

use App\Cotenant;
use Illuminate\Http\Request;
use DB;

/**
 *
 */
class CotenantRepository
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
      $cotenant = Cotenant::create([
        'user_id' => $request->user_id,
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

      if (!$cotenant) {

        // If creation of the tenant fails, roll back the database to its initial state
        DB::rollback();

      }else {

        // If creation of the tenant is successful, then commit transaction
        DB::commit();

        // return the tenant created
        return $cotenant;

      }

    }

    /**
     * Fetch all Tenant existing in the database
     *
     * @return object $tenant
     *
     */
    public function cotenants()
    {

      // Fetch all tenants existing in the database
      $cotenants = Cotenant::leftjoin('users', 'users.id', '=', 'cotenants.user_id')->select('*')->get();

      // return list of properties;
      return $cotenants;

    }

    /**
     * Fetch a Tenant
     *
     * @param int $id
     *
     * @return object $tenant
     *
     */
     public function fetchACoTenant($id)
     {
        $cotenant = Cotenant::where('cotenants.id', $id)->leftjoin('users', 'users.id', '=', 'cotenants.user_id')->select('*')->get();
        return $cotenant;
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
    public function updateCoTenant($id, $request)
    {
        // Fetch tenant with $id from database
        $cotenant = Cotenant::findOrfail($id);

        // Update tenant details
        $cotenant->update($request->all());

        // return tenant
        return $cotenant;

    }

}

?>
