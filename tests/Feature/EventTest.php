<?php

use App\Models\User;
use App\Models\Event;

use function Pest\Laravel\{actingAs, get, post, put, delete};

beforeEach(function () {
    $this->user = User::factory()->create();
    actingAs($this->user);
});

test('user can view event list', function () {
    Event::factory()->count(3)->create();

    get(route('events'))
        ->assertOk()
        ->assertSee('events');
});

test('user can create an event', function () {
    $response = post(route('events.store'), [
        'eventInfo' => [
            'name' => 'Novo Evento',
            'description' => 'Descrição do evento',
        ],
        'address' => [
            'address' => 'Rua A',
            'number' => '123',
            'complement' => 'Apto 2',
            'zipcode' => '12345-000',
            'city' => 'CidadeX',
            'state' => 'SP',
        ],
        'schedule' => [
            'starts_at' => now()->addDays(1)->format('Y-m-d'),
            'starts_time' => '10:00',
            'ends_at' => now()->addDays(1)->format('Y-m-d'),
            'ends_time' => '12:00',
        ],
        'vacancy' => [
            'max_subscription' => 50,
        ],
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('events', ['name' => 'Novo Evento']);
});

test('user can update an event', function () {
    $event = Event::factory()->create(['owner_id' => $this->user->id]);

    put(route('events.update', $event), [
        'eventInfo' => [
            'name' => 'Evento Editado',
            'description' => 'Editado',
        ],
        'address' => [
            'address' => 'Rua B',
            'number' => '321',
            'complement' => '',
            'zipcode' => '54321-000',
            'city' => 'CidadeY',
            'state' => 'RJ',
        ],
        'schedule' => [
            'starts_at' => now()->addDays(2)->format('Y-m-d'),
            'starts_time' => '13:00',
            'ends_at' => now()->addDays(2)->format('Y-m-d'),
            'ends_time' => '16:00',
        ],
        'vacancy' => [
            'max_subscription' => 30,
        ],
    ])->assertRedirect();

    $this->assertDatabaseHas('events', ['name' => 'Evento Editado']);
});

test('user can delete their own event', function () {
    $event = Event::factory()->create(['owner_id' => $this->user->id]);

    delete(route('events.destroy', $event))->assertRedirect();

    $this->assertSoftDeleted($event);
});
