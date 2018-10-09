<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\AuthRepository;

class AuthController extends Controller
{

  /**
   * The Authentication
   *
   * @var object
   */
  private $auth;


  /**
   * Class constructor
   */
  public function __construct(AuthRepository $auth)
  {
      // Inject AuthRepository Class into AuthController
      $this->auth = $auth;

  }


  public function login(Request $request)
  {

    try {

      // Call the create method of UserRepository
      $auth = $this->auth->login($request);

      // Create a custom array as response
      $response = [
          "success" => true,
          "status" => 201,
          "data" => $auth
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
