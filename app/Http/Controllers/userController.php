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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // $user = auth()->user()->find($request->$id);

        // if ($user) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'User not found'
        //     ], 400);
        // } 

        // return response()->json([
        //     'success'=>false,
        //     'message'=>'User can not be found'
        // ], 500);
    }

    public function allusers()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $logUser = auth()->user();
        $user = User::find($logUser->id);

        if ($user OR $logUser->isAdmin == true) {

            $updated = $user->fill($request->all())->save();

            if($updated) {

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
