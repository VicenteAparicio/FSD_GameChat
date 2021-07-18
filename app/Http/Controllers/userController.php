<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->isAdmin) {
            $allUsers = User::all();
            return response()->json([
                'success' => true,
                'data' => $allUsers
            ], 200);
        }else{      
            return response()->json([
                'success' => false,
                'messate' => 'You need admin authorization'
            ], 400);
        }
    }

    /**
     * Display user by Id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function userById(Request $request)
    {
        $user = User::find($request->user_id);
    
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } 

        return response()->json([
            'success'=>false,
            'message'=>'User can not be found'
        ], 500);
    }

    /**
    * Display user by userName.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function userByName(Request $request)
    {
        $user = User::where('username', $request->user_name)->get();
    
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } 

        return response()->json([
            'success'=>false,
            'message'=>'User can not be found'
        ], 500);
    }

    /**
    * Display user by SteamId.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function userBySteamId(Request $request)
    {
        $user = User::where('steamId', $request->steam_id)->get();
    
        if ($user) {
            return response()->json([
                'success' => true,
                'data' => $user
            ], 200);
        } 

        return response()->json([
            'success'=>false,
            'message'=>'User can not be found'
        ], 500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $logUser = auth()->user();
        $user = User::find($request->user_id);

        if ($request->user_id == $logUser->id || $logUser->isAdmin == true) {

            $userUp = $user->fill([
                'username'=>$request->username,
                'email'=>$request->email,
                'password'=>bcrypt($request->password)
            ])->save();

            if($userUp) {

                return response()->json([
                    'success' => true,
                    'data' => $user

                ], 400);

            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'User can not be updated'
                ], 500);
            }

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You don\'t have permission'
            ], 500);
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // GET USER
        $logUser = auth()->user();
        $user = User::find($logUser->id);
        
        if ($user OR $user->isAdmin == true) {
        
            $user->isActive = 0;
            $user->save();
        
            return response()->json([
                'success' => true,
                'data' => $user
        
            ], 200);
        
        } else {
        
            return response()->json([
        
                'success' => false,
                'message' => 'Error, user not deleted'
        
            ], 400);
            
        }
    }
}
