<?php

namespace App\Models\Blog;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
