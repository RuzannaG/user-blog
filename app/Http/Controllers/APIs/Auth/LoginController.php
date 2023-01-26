<?php

namespace App\Http\Controllers\APIs\Auth;

use App\Http\Controllers\APIs\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @param Request $request
     * @return JsonResponse
     */

     public function login(Request $request){

        if(Auth::attempt(['email' => $request->json('email'), 'password' => $request->json('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            return $this->sendResponse($success, 'User login successfully.');
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function logout (Request $request) {
        Auth::user()->token()->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
