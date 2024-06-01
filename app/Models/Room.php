<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        "name",
        "owner_id",
        "deleted_at"
    ];

    public function messages(): HasMany {
        return $this->hasMany(Message::class, "room_id");
    }

    public function owner(): BelongsTo {
        return $this->belongsTo(User::class, "owner_id");
    }
}
