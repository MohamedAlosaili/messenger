<?php

namespace App\Repositories;

use App\Models\Message;
use App\Models\Room;
use Carbon\Carbon;

class MessageRepository {


    public function create($data): Message {
        return Message::create($data);
    }

    public function getRoomMessages($roomId)
    {
        return Message::where([
            'room_id' => $roomId,
            'deleted_at' => null
        ])->get();
    }

    public function getMessage($messageId) {
        $message = Message::find($messageId);
        if($message !== null && $message["deleted_at"] !== null) {
            return;
        }

        return $message;
    }

    public function update($id, $data)
    {
        return Message::find($id)->update($data);
    }

    public function delete($id) {
        // Use transaction here
    return Message::find($id)->update(["deleted_at" => Carbon::now()]);
    }
}
