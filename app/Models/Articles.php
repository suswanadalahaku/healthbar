<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'content',
        'image',
        'is_approved'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }

    public function validateArticles()
    {
        return $this->hasMany(ValidateArticles::class, 'id_artikel', 'id');
    }
}
