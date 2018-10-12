<?php

namespace App\Api\v1\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Api\v1\Repositories\GroupRepository;
use App\Api\v1\Repositories\AdminRepository;

class GroupController extends Controller
{

  /**
   * The User
   *
   * @var object
   */
  private $group;

  /**
   * The Admin
   *
   * @var object
   */
  private $admin;


  /**
   * Class constructor
   */
  public function __construct(GroupRepository $group, AdminRepository $admin)
  {
      // Inject UserRepository Class into UserController
      $this->group = $group;
      $this->admin = $admin;
      $this->middleware('auth');
  }

  /**
   * Create a  new User
   *
   * @param object $request
   *
   * @return JSON
   *
   */
  public function create (Request $request)
  {
      try {

          $isAdmin = $this->admin->isAdmin($request->header('Authorization'));

          if (!$isAdmin) {

              $group = "Unauthorized";

          }else {

              // Call the create method of UserRepository
              $group = $this->group->create($request);

          }

          // Create a custom array as response
          $response = [
              "success" => true,
              "status" => 201,
              "data" => $group
          ];

          // return the custom in JSON format
          return response()->json($response);

      } catch (\Exception $e) {

        // Create a custom response
        $response = [
            "success" => false,
            "status" => 502,
        ];

        // return the custom in JSON format
        return response()->json($response);

      }

  }

  /**
   * Fetch all existing Users
   *
   * @return JSON
   */
  public function groups ()
  {
    try {

      // Call the users method of UserRepository
      $groups = $this->group->groups();

      // Create a custom response
      $response = [
          "success" => true,
          "status" => 200,
          "data" => $groups
      ];

      // return the custom in JSON format
      return response()->json($response);

    } catch (\Exception $e) {

      // Create a custom response
      $response = [
          "success" => false,
          "status" => 502,
      ];

      // return the custom in JSON format
      return response()->json($response);

    }

  }

}
