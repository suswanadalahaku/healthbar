<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'is_aended',
    ];

    public function messages()
    {
        return $this->hasMany(Message::class, 'session_id', 'id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    // Relasi ke User (to_user)
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}
