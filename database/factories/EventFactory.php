<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = \App\Models\Event::class;

    public function definition()
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $end = (clone $start)->modify('+'.rand(1,5).' hours');

        return [
            'uuid_code' => Str::uuid()->toString(),
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'address' => $this->faker->streetName(),
            'complement' => $this->faker->secondaryAddress(),
            'zipcode' => $this->faker->postcode(),
            'number' => $this->faker->buildingNumber(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'starts_at' => $start,
            'ends_at' => $end,
            'max_subscription' => rand(10, 100),
            'is_active' => true,
            'owner_id' => User::factory(),
        ];
    }
}
