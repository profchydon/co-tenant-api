<?php

namespace App\Api\v1\Repositories;

use App\Interest;
use App\User;
use App\Accept;
use App\Transaction;
use App\Cotenant;
use App\Visit;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

/**
 *
 */
class AdminRepository
{

  /**
 * Create a  new Admin
 *
 * @param object $request
 *
 * @return object $user
 *
 */
  public function create($request)
  {

    // Begin database transaction
    DB::beginTransaction();

    // Create User
    $user = User::create([
      'email' => strtolower($request->email),
      'password' => Hash::make($request->password),
      'first_name' => $request->first_name,
      'last_name' => $request->last_name,
      'gender' => $request->gender,
      'phone_number' => $request->phone_number,
      'user_group' => "admin",
      'active' => 0
    ]);

    if (!$user) {

      // If User isn't created, rollback database to initial state
      DB::rollback();

      return $user;

    }else {

      // If User is created, commit transaction to the database
      DB::commit();

      return $user;

    }

  }



    /**
   * Match a tenant to a property
   *
   * @param object $request
   *
   * @return object $matchTenant
   *
   */
    public function matchTenantToProperty($request)
    {

        // Begin database transaction
        DB::beginTransaction();

        // Create an interest for the tenant
        $matchTenant = Interest::create([
            'property_id' => $request->property_id,
            'cotenant_id' => $request->cotenant_id,
        ]);

        if (!$matchTenant) {

          // If the instance of interest is not created, roll back database to its initial state
          DB::rollback();

        }else {

          // If the instance of interest is created, commit the transaction
          DB::commit();

          return $matchTenant;
        }

    }


    // Check if api key belongs to an admin
    public function isAdmin($api_key)
    {
      // Fetch user with the api_key provided
      $isAdmin = User::where('api_key', $api_key)->first();

      if ($isAdmin->user_group == "admin") {

          // If user has admin privileges
          return true;

      }else {

        // If user does not have admin privileges
        return false;

      }

    }

    /**
   * Fetch all records of a tenant
   *
   * @param object $request
   *
   * @return array $data
   *
   */
    public function cotenantRecords($request)
    {
        // Fetch the user with email
        $user = User::where('email', 'like', $request->email)->first();

        if (!$user) {

            $data = "User does not exist";

        }else {

            // Fetch the cotenant details
            $cotenant = Cotenant::where('user_id', $user->id)->first();

            // Fetch the cotenant's accept details
            $accepts = Accept::where('cotenant_id' , $cotenant->id)->get();

            // Fetch the cotenant's transaction details
            $transactions = Transaction::where('cotenant_id' , $cotenant->id)->get();

            // Fetch the cotenant's visit details
            $visit = Visit::where('cotenant_id' , $cotenant->id)->get();

            // Fetch the cotenant's interest details
            $interest = Interest::where('cotenant_id' , $cotenant->id)->get();

            $data['user'] = $user;
            $data['cotenant'] = $cotenant;
            $data['accepts'] = $accepts;
            $data['transactions'] = $transactions;
            $data['interest'] = $interest;
            $data['visit'] = $visit;

        }

        return $data;
    }

}

?>
