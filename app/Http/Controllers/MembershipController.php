<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;
use Mockery\Undefined;

class MembershipController extends Controller
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

            $allMemberships = Membership::where('isActive', true)->get();

            return response()->json([
                'success'=>true,
                'message'=>'You are joined to this parties',
                'data'=>$allMemberships
            ], 200);

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You shall not pass!! (You need admin access)'
            ], 500);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $membership = Membership::where('party_id', $request->party_id)->where('user_id', $user->id)->get();

        if ($membership->isEmpty()) {

            $membership = Membership::create([
                'party_id'=>$request->party_id,
                'user_id'=>$user->id,
            ]);

            if ($membership) {

                return response()->json([
                    'success'=>true,
                    'message'=>'Welcome to the party!!',
                    'data'=>$membership
                ], 200);

            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'Error, you didn\'t join to the party'
                ], 500);
            }

        } else if ($membership[0]->isActive == 0) {

            $membership[0]->isActive = 1;
            $membership[0]->save();
            
            return response()->json([
                
                'success'=>false,
                'message'=>'Welcome back to the party!!',
                'data' =>$membership

            ], 400);

        } else {

            return response()->json([
                
                'success'=>false,
                'message'=>'You are already on the party',
                'data' =>$membership

            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function membershipByUserId(Request $request)
    {
        $user = auth()->user();

        if ($user->id == $request->user_id || $user->isAdmin) {

            $allMemberships = Membership::where('isActive', true)->where('user_id', $request->user_id)->get();

            return response()->json([
                'success'=>true,
                'message'=>'Welcome to the party!!',
                'data'=>$allMemberships
            ], 200);

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You shall not pass!! (You need admin access)'
            ], 500);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        $membership = Membership::where('party_id', $request->party_id)->where('user_id', $user->id)->get();
        
        if ($membership->isEmpty() || $membership[0]->isActive == false) {

            return response()->json([

                'success'=>false,
                'message'=>'You are not in the party'

            ], 400);

        } else {

            $membership[0]->isActive = 0;
            $membership[0]->save();

            return response()->json([

                'success'=>true,
                'message' =>'You leave the party'

            ], 200);
        }
    }
}
