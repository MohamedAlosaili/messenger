<?php

namespace App\Services;

use App\Models\Room;
use App\Models\User;
use App\Repositories\RoomRepository;
use App\Repositories\UserRepository;

class RoomService {

    private $roomRepository;

    public function __construct(RoomRepository $roomRepository) {
        $this->roomRepository = $roomRepository;
    }


    public function create($data): Room {
        return $this->roomRepository->create($data);
    }

    public function getRooms()
    {
        return $this->roomRepository->getRooms();
    }

    public function getRoom($id): ?Room
    {
        return $this->roomRepository->getRoom($id);
    }

    public function delete($id, $userId) {
        $room = $this->roomRepository->getRoom($id);


        if(!$room || $room["owner_id"] !== $userId) {
            return false;
        }

        return $this->roomRepository->delete($id);
    }
}
