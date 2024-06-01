<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{

    private $messageService;

    public function __construct(MessageService $messageService) {
        $this->messageService = $messageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(string $roomId)
    {
        $roomMessages = $this->messageService->getRoomMessages($roomId);

        return response()->json([
            "success" => true,
            "data" => [
                "messages"=> $roomMessages,
                ]
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $roomId)
    {
        $data = $request->validate(['content' => "required|string|max:500"]);
        $data['sender_id'] = $request->user()['id'];
        $data['room_id'] = $roomId;


        $message = null;
        try {
            $message = $this->messageService->create($data);

        } catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message'=> $e->getMessage()
                ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'message' => $message
            ]
        ], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $messageId)
    {
        $data = $request->validate(['content'=> 'required|string|max:500']);
        $userId = $request->user()['id'];

        $message = $this->messageService->getMessage($messageId);

        if(!$message) {
            return response()->json([
                'success' => false,
                'errorCode' => 'message_not_found'
            ], Response::HTTP_NOT_FOUND);
        }

        if($message["sender_id"] !== $userId) {
            return response()->json([
                'success' => false,
                'errorCode' => 'forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        $success = $this->messageService->update($messageId, $data);

        if (!$success) {
            return response()->json([
                'success'=> false,
                'errorCode'=> 'internal_server_error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $message['content'] = $data["content"];

        return response()->json([
            'success'=> true,
            'data'=> [
                'message'=> $message
            ]
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $messageId)
    {
        $userId = $request->user()['id'];

        $message = $this->messageService->getMessage($messageId);

        if(!$message) {
            return response()->json([
                'success' => false,
                'errorCode' => 'message_not_found'
            ], Response::HTTP_NOT_FOUND);
        }

        if($message["sender_id"] !== $userId) {
            return response()->json([
                'success' => false,
                'errorCode' => 'forbidden'
            ], Response::HTTP_FORBIDDEN);
        }

        $success = $this->messageService->delete($messageId);

        if (!$success) {
            return response()->json([
                'success'=> false,
                'errorCode'=> 'internal_server_error'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'success'=> true,
            'data'=> null
        ], Response::HTTP_OK);
    }
}
