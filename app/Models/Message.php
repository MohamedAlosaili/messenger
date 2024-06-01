<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{

    protected $fillable = [
        "content",
        "room_id",
        "sender_id",
        "created_at",
        "deleted_at",
        "updated_at",
    ];

    public function sender(): BelongsTo {
        return $this->belongsTo(User::class, "sender_id");
    }

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class, "room_id");
    }

}
