<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comments;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'image', 'content', 'created_at'];

    protected $primaryKey = 'id';

    protected $table = 'blogs';

    public function rates()
    {
        return $this->hasMany(Rate::class, 'id_blogs');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'id_blogs');
    }
}
