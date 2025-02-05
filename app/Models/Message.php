<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'is_read',
        'session_id'
    ];

    public function fromUser(){
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser(){
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function isEnded()
    {
        return $this->belongsTo(ChatSession::class, 'session_id', 'id');
    }
    
    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }
}
