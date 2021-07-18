<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;


class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user) {

            $allParties = Party::where('isActive', true);

            return response()->json([
                'success' => true,
                'data' => $allParties
            ], 200);

        } else {      

            return response()->json([
                'success' => false,
                'messate' => 'You need need to loguin'
            ], 400);

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
        $user= auth()->user();

        $this->validate($request, [
            'partyName'=>'required',
            'description'=>'required',
            'game_id'=>'required',
        ]);

        $party = Party::create([
            'partyName'=>$request->partyName,
            'description'=>$request->description,
            'game_id'=>$request->game_id,
            'owner_id'=>$user->id
        ]);
        

        if ($party) {
            return response()->json([
                'success'=>true,
                'data'=>$party->toArray()
            ], 200);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'Party not created'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function partyById(Request $request)
    {
        $party = Party::find($request->party_id);

        if(!$party) {
            return response()->json([
                'success'=>false,
                'message'=>'Party not found'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'data'=>$party
        ], 400);
    }

    public function partiesByOwner(Request $request)
    {
        $party = Party::where('owner_id', $request->owner_id)->get();

        if(!$party) {
            return response()->json([
                'success'=>false,
                'message'=>'Party not found'
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'data'=>$party->toArray()
        ], 400);
    }

    public function partiesByGame(Request $request)
    {
        $party = Party::where('game_id', $request->game_id)->get();

        if(!$party) {
            return response()->json([
                'success'=>false,
                'message'=>'Party not found ',
            ], 400);
        }

        return response()->json([
            'success'=>true,
            'data'=>$party->toArray()
        ], 400);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        $party = Party::find($request->party_id);
        
        // CHECK USER OWNS THE PARTY OR USER IS ADMIN
        if ($party->owner_id == $user->id OR $user->isAdmin == true) {

            $updated = $party->fill($request->all())->save();

            if ($updated) {
                return response()->json([
                    'success'=>true,
                    'data'=>$party
                ], 200);
            } else {
                return response()->json([
                    'success'=>false,
                    'message'=> 'Error party not updated'
                ], 500);

            }
        } else {
            return response()->json([
                'success'=>false,
                'message'=> 'You can not update this party'
            ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $user = auth()->user();
        $party = Party::find($request->party_id);

        // CHECK USER OWNS THE PARTY OR USER IS ADMIN
        if ($party->owner_id == $user->id OR $user->isAdmin == true) {

            $party->isActive = 0;
            $party->save();

            return response()->json([
                'success' => true,
                'data' => $party

            ], 200);

        } else {

            return response()->json([

                'success' => false,
                'message' => 'You can not delete this party'

            ], 400);
            
        }
    }
}
