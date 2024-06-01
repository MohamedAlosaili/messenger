<?php

namespace App\Repositories;

use App\Models\Room;
use App\Services\MessageService;
use Illuminate\Support\Facades\DB;

class RoomRepository {

    private $messageService;

    public function __construct(MessageService $messageService) {
        $this->messageService = $messageService;
    }

    public function create($data): Room {
        return Room::create($data);
    }

    public function getRooms()
    {
        return Room::where('deleted_at', null)->get();
    }

    public function getRoom($id): ?Room
    {
        $room = Room::find($id);

        if (!$room || $room["deleted_at"]) {
            return null;
        }

        return $room;
    }

    public function delete(Room $room): void {
        // Use transaction here
        DB::transaction(function () use ($room) {
            try {
                $room->delete();
                $this->messageService->deleteRoomMessages($room['id']);

                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                return false;
            }

        });
    }
}
