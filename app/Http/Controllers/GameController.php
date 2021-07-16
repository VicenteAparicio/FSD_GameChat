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
        $user = auth()->user();

        if ($user) {

            $allGames = Game::all();

            return response()->json([
                'success' => true,
                'data' => $allGames
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
        $user = auth()->user();

        if ($user->isAdmin) {

            $exist = Game::where('title', $request->title);

            if (!$exist) {

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
                    ], 200);
        
                } else {

                    return response()->json([
                        'success'=>false,
                        'message'=>'Game not added'
                    ], 500);
                    
                }

            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'Game already on database'
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $game = Game::find($request->id);

            if ($game) {

                $updated = $game->fill($request->all())->save();

                if ($updated) {

                    return response()->json([
                        'success'=>true
                    ], 200);

                } else {

                    return response()->json([
                        'success'=>false,
                        'message'=>'Game can not be updated'
                    ], 500);

                }

            } else {

                return response()->json([
                    'success' => false,
                    'message' => 'You need admin authorization'
                ], 400);

            }
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $game = Game::find($request->game_id)->delete();
            
            if ($game){

                return response()->json([
                    'success'=>true,
                    'data'=>$game
                ], 200);
    
            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'Game can not be deleted cause is being used'
                ], 500);

            }

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You need admin authorization'
            ], 400);
        }


    }
}
