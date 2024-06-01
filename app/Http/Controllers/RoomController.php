<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomController extends Controller
{

    private $roomService;


    public function __construct(RoomService $roomService){
        $this->roomService = $roomService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = $this->roomService->getRooms();

        return response()->json([
            "status" => true,
            "data" => $rooms
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRoomRequest $request)
    {
        $data = $request->validated();

        $data["owner_id"] = $request->user()['id'];

        $room = $this->roomService->create($data);

        return response()->json([
            "status" => true,
            "data" => $room
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = $this->roomService->getRoom($id);

        if(!$room) {
            return response()->json([
                "status" => false,
                "errorCode" => "room_not_found"
            ], Response::HTTP_NOT_FOUND);
        }

        $data = new RoomResource($room);

        return response()->json([
            "status" => true,
            "data" => $data
        ], Response::HTTP_OK);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
