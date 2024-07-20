<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = ['id_user', 'id_blogs', 'rate', 'time'];

    protected $table = 'rates';

    public function blogPost()
    {
        return $this->belongsTo(BlogPost::class, 'id_blogs');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
