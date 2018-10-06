<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class UserController extends Controller
{

    public function create (Request $request)
    {

        try {

          DB::beginTransaction();

          $user = User::create([
            'email' => strtolower($request->email),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'user_group' => $request->user_group,
          ]);

          if (!$user) {

            DB::rollback();

          }else {

            $response = [
                "success" => true,
                "status" => 200,
                "data" => $user
            ];

            DB::commit();
          }

          return response()->json($response);

        } catch (\Exception $e) {

          $response = [
              "success" => false,
              "status" => 201,

          ];

          return response()->json($response);

        }


    }

    public function users ()
    {
      // code...
      $user = User::all();

      $response = [
          "success" => true,
          "status" => 200,
          "data" => $user
      ];

      return response()->json($response , 200);
    }

}

?>
