<?php

namespace Database\Factories;

use App\Models\EventGuest;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventGuestFactory extends Factory
{
    use HasFactory;
    protected $model = EventGuest::class;

    public function definition()
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
