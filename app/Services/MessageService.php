<?php

namespace App\Services;

use App\Models\Message;
use App\Repositories\MessageRepository;
use Carbon\Carbon;
use Exception;

class MessageService {

    private $messageRepository;
    private $roomService;

    public function __construct(MessageRepository $messageRepository, RoomService $roomService) {
        $this->messageRepository = $messageRepository;
        $this->roomService = $roomService;
    }

    public function create($data)
    {
        $room = $this->roomService->getRoom($data["room_id"]);
        if (!$room) {
            throw new Exception("room_not_found");
        }

        return $this->messageRepository->create($data);
    }

    public function getRoomMessages($roomId) {
        return $this->messageRepository->getRoomMessages($roomId);
    }

    public function update($id, $data) {
        return $this->messageRepository->update($id, $data);
    }

    public function getMessage($messageId)
    {
        return $this->messageRepository->getMessage($messageId);
    }

    public function deleteUserMessages($userId)
    {
        return Message::where("user_id", $userId)->update(["deleted_at" => Carbon::now()]);;
    }

    public function deleteRoomMessages($roomId)
    {
        return Message::where("room_id", $roomId)->update(["deleted_at" => Carbon::now()]);;
    }

    public function delete($messageId) {
        return $this->messageRepository->delete($messageId);
    }

}
