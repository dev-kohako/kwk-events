<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        // Para cada usuário, cria entre 1 e 3 eventos
        foreach ($users as $user) {
            Event::factory(rand(1, 3))->create([
                'owner_id' => $user->id,
            ]);
        }
    }
}
