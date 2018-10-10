<?php

namespace App\Api\v1\Controllers;

use App\Group;
use Illuminate\Http\Request;
use App\Api\v1\Repositories\GroupRepository;

class GroupController extends Controller
{

  /**
   * The User
   *
   * @var object
   */
  private $group;


  /**
   * Class constructor
   */
  public function __construct(GroupRepository $group)
  {
      // Inject UserRepository Class into UserController
      $this->group = $group;
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

          // Call the create method of UserRepository
          $group = $this->group->create($request);

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
