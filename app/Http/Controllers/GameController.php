<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display all active games.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if ($user) {

            $allGames = Game::where('isActive', true)->get();

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
     * Add new game to the database.
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
                'message'=>'You need admin authorization'
            ], 400);
        }
    }

    /**
     * Display game by id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function gameById(Request $request)
    {
        $user = auth()->user();

        if ($user) {

            $gameById = Game::find($request->game_id);

            if ($gameById) {

                return response()->json([
                    'success' => true,
                    'data' => $gameById
                ], 200);

            } else {            
            
                return response()->json([
                    'success' => false,
                    'messate' => 'Game not found'
                ], 400);
            }

        } else {      

            return response()->json([
                'success' => false,
                'messate' => 'You need need to loguin'
            ], 500);
        }
    }

    /**
     * Edit game.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        if ($user->isAdmin) {

            $game = Game::find($request->game_id);

            if ($game) {

                $updated = $game->fill($request->all())->save();

                if ($updated) {

                    return response()->json([
                        'success'=>true,
                        'data' => $game
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
                    'message' => 'You need admin authorization meh'
                ], 400);

            }
        } 
    }

    /**
     * Delete game from view.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // GET USER 
        $user = auth()->user();

        // CHECK USER ADMIN ATRIBUTE
        if ($user->isAdmin) {

            // GET GAME
            $game = Game::find($request->game_id);

            // UPDATE ATRIBUTE
            $game->isActive = 0;
            $game->save();
            
            if ($game){

                return response()->json([
                    'success'=>true,
                    'data'=>$game
                ], 200);
    
            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'Game was not deleted'
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
