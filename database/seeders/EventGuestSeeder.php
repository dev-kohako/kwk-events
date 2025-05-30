<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventGuest;
use App\Models\Event;
use App\Models\User;

class EventGuestSeeder extends Seeder
{
    public function run()
    {
        $events = Event::all();
        $users = User::all();

        foreach ($events as $event) {
            $subscribers = $users->random(rand(0, min($event->max_subscription, $users->count())));

            foreach ($subscribers as $user) {
                if ($user->id == $event->owner_id) continue;

                $exists = EventGuest::where('event_id', $event->id)
                    ->where('user_id', $user->id)
                    ->exists();

                if (!$exists) {
                    EventGuest::create([
                        'event_id' => $event->id,
                        'user_id' => $user->id,
                        'uuid_code' => \Illuminate\Support\Str::uuid()->toString(),
                    ]);
                }
            }

            // Inscreve automaticamente o dono do evento
            if (!EventGuest::where('event_id', $event->id)->where('user_id', $event->owner_id)->exists()) {
                EventGuest::create([
                    'event_id' => $event->id,
                    'user_id' => $event->owner_id,
                    'uuid_code' => \Illuminate\Support\Str::uuid()->toString(),
                ]);
            }
        }
    }
}
