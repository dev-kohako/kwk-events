<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class EventGuest extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'event_id', 'uuid_code'];

    protected static function booted()
    {
        static::creating(function ($guest) {
            if (empty($guest->uuid_code)) {
                $guest->uuid_code = Str::uuid()->toString();
            }
        });
    }

    public function guests()
    {
        return $this->hasMany(EventGuest::class);
    }


    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
