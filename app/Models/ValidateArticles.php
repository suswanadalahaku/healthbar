<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValidateArticles extends Model
{
    use HasFactory;

    protected $table = 'validate_articles';
    protected $fillable = ['id_artikel', 'message', 'status'];

    public function article()
    {
        return $this->belongsTo(Articles::class, 'id_artikel');
    }
}
