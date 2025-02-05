<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

    public function unreadMessages()
    {
        return $this->hasMany(Message::class, 'from_user_id')->where('is_read', 0);
    }

    public function sentSessions()
    {
        return $this->hasMany(ChatSession::class, 'from_user_id');
    }

    // Relasi ke ChatSession yang diterima oleh User
    public function receivedSessions()
    {
        return $this->hasMany(ChatSession::class, 'to_user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'from_user_id')->orWhere('to_user_id', $this->id);
    }
    

}
