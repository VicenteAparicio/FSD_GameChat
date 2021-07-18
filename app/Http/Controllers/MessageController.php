<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Membership;
use Illuminate\Http\Request;

class MessageController extends Controller
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

        $membership = Membership::where('party_id', $request->party_id)->where('user_id', $user->id)->get();
        
        if ($membership->isEmpty() || $membership[0]->isActive == false) {

            return response()->json([
                'success'=>true,
                'message'=>'You are not in the party'
            ], 400);

        } else {

            $this->validate($request, [
                'message'=>'required|min:4'
            ]);

            $message = Message::create([
                'message'=>$request->message,
                'party_id'=>$request->party_id,
                'user_id'=>$user->id,
                'date'=>$request->date
            ]);

            if (!$message) {
                return response()->json([
                    'success'=>false,
                    'message'=>'Message not created ' 
                ], 500);
            }

            return response()->json([
                'success'=>true,
                'data'=>$message->toArray()
            ], 200);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
