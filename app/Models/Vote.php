<?php

namespace App\Models;

use App\Enums\VoteType;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'pengaduan_id', 'type'];

    protected $casts = [
        'type' => VoteType::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
