<?php

namespace App\Http\Controllers\APIs\Auth;

use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\APIs\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController

{
    /**
     * Register api
     *
     * @return JsonResponse
     */

     public function register(Request $request): JsonResponse
     {
         $validator = Validator::make($request->all(), [
             'name' => 'required',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|min:8|confirmed',
             'image' => 'required|file|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
         ]);
 
         if($validator->fails()){
             return $this->sendError('Validation Error.', $validator->errors()->messages(), 419);
         }
         $input = $request->all();
         $input['password'] = Hash::make($input['password']);
         $input['image_id'] = null;
         if($request->hasFile('image')){
             $image = Image::upload($request->file('image'));
             if($image){
                 $input['image_id'] = $image->id;
             }
         }
         $user = User::create($input);
         $success['token'] =  $user->createToken(config('app.name'))->accessToken;
         $success['user'] =  User::find($user->id);
         return $this->sendResponse($success, 'User register successfully.');
     }



    /**
     * Login api
     *
     * @return JsonResponse
     */

    // public function login(Request $request): JsonResponse
    // {
    //     if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
    //         $user = Auth::user();
    //         $success['token'] =  $user->createToken('MyApp')-> accessToken;
    //         $success['user'] =  $user;
    //         return $this->sendResponse($success, 'User login successfully.');
    //     }
    //     else{
    //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
    //     }
    // }

}
