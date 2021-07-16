<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
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
        $user = auth()->user();

        $existeuserparty = Membership::where('party_id', $request->party_id AND 'user_id', $user->id);
        
        if ($existeuserparty->isEmpty()) {

            $membership = Membership::create([
                'party_id'=>$request->party_id,
                'user_id'=>$request->$user->id,
            ]);

            if ($membership) {

                return response()->json([
                    'success'=>true,
                    'data'=>$membership
                ], 200);

            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'Membership not created'
                ], 500);

            }

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'User is already on this party'
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Membership $membership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Membership  $membership
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        //
    }
}
