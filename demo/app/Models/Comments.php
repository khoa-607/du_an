<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'cmt', 'id_user', 'id_blogs', 'avatar_user', 'name_user', 'level', 'time'
    ];

    protected $table = 'comments';

    // Ensure the 'time' attribute is parsed as a Carbon instance
    protected $dates = ['time'];

    public function replies()
    {
        return $this->hasMany(Comments::class, 'level')->where('level', '>', 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function topLevelComments()
    {
        return $this->where('level', 0)->get();
    }

    public function getTimeAttribute($value)
    {
        return Carbon::parse($value);
    }

}
