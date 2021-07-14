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
        $parties = auth()->user()->parties;

        return response()->json([
            'success'=>true,
            'data'=>$parties
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'partyName'=>'required',
            'description'=>'required',
            'game_id'=>'required',
            'owner_id'=>'required',
        ]);


        $party = Party::create([
            'partyName'=>$request->partyName,
            'description'=>$request->description,
            'game_id'=>$request->game_id,
            'owner_id'=>$request->owner_id
        ]);
        

        if ($party) {
            return response()->json([
                'success'=>true,
                'data'=>$party->toArray()
            ]);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'Party not added'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        
        $party = auth()->user()->parties()->find($request->$id);

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

    public function gameparties(Request $request)
    {

        $game_id = $request->game_id;
        
        $party = Party::where('game_id', $game_id)
        ->get();

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
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $party = auth()->user()->parties()->find($id);

        if (!$party) {
            return response()->json([
                'success'=>false,
                'message'=> 'Party not found'
            ], 400);
        }

        $updated = $party->fill($request->all())->save();

        if ($updated) {
            return response()->json([
                'success'=>true
            ]);
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'Party can not be updated'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Party  $party
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $party = auth()->user()->parties()->find($id);

        if (!$party) {
            return response()->json([

                'success' => false,
                'message' => 'Party not found'

            ], 400);
        }

        if ($party->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'suceess'=>false,
                'message'=>'Party can not be deleted'
            ], 500);
        }
    }
}
