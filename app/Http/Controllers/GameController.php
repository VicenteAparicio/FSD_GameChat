<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = auth()->user()->games;

        return response()->json([
            'success'=>true,
            'data'=>$games
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
        $user = auth()->user();

        if ($user->isAdmin) {

            $this->validate($request, [
                'title'=>'required',
                'thumbnail_url'=>'required',
                'url'=>'required',
            ]);
    
            $game = Game::create([
                'title'=>$request->title,
                'thumbnail_url'=>$request->thumbnail_url,
                'url'=>$request->url
            ]);
            
            if ($game){
                return response()->json([
                    'success'=>true,
                    'data'=>$game
                ]);
    
            } else {
                return response()->json([
                    'success'=>false,
                    'message'=>'Game not added'
                ], 500);
            }
        } else {
            return response()->json([
                'success'=>false,
                'message'=>'You need admin authorization'
            ], 400);
        }

        
        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $game_id = $request->game_id;
        return Game::where('id', $game_id)->delete();
    }
}
