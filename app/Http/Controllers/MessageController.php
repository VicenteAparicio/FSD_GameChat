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
        $user = auth()->user();

        if ($user->isAdmin) {

            $allmessages = Message::where('isActive', true)->get();

            return response()->json([
                'success'=>true,
                'message'=>'Welcome to the party!!',
                'data'=>$allmessages
            ], 200);

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You shall not pass!! (You needadmin access)'
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messagesByPartyId(Request $request)
    {
        $user = auth()->user();

        $membership = Membership::where('party_id', $request->party_id)->where('user_id', $user->id)->get();

        if(!$membership->isEmpty() || $user->isAdmin) {

            $messByPartyId = Message::where('party_id', $request->party_id)->where('isActive', true)->get();


            return response()->json([
                'success'=>true,
                'message'=>'Messages:',
                'data'=>$messByPartyId
            ], 200);

        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You shall not pass!! (You needadmin access)'
            ], 500);

        }
    }

    /**
     * Update message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $logUser = auth()->user();
        $message = Message::find($request->message_id);

        if ($request->user_id == $logUser->id || $logUser->isAdmin == true) {

            $messageUp = $message->fill([
                'message'=>$request->message,
            ])->save();

            if($messageUp) {

                return response()->json([
                    'success' => true,
                    'data' => $message

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
     * Remove message by message id.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = auth()->user();

        $message = Message::find($request->message_id);
        
        if ($user->isAdmin || $message->user_id == $user->id) {

            if ($message) {

                $message->isActive = 0;
                $message->save();

                return response()->json([

                    'success'=>true,
                    'message' =>'Message deleted'

                ], 200);

            } else {

                return response()->json([
                    'success'=>false,
                    'message'=>'There is no message here!!'
                ], 400);

            }
            
        } else {

            return response()->json([
                'success'=>false,
                'message'=>'You have no power here to delete this message!!'
            ], 400);
        }
    }
}
