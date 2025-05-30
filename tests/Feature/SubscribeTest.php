<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\EventGuest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper para verificar mensagem de erro específica na sessão.
     */
    protected function assertSessionHasErrorMessage($response, string $message)
    {
        $response->assertSessionHasErrors();
        $errors = session('errors')->all();
        $this->assertTrue(
            in_array($message, $errors),
            "Mensagem de erro esperada não encontrada na sessão: '{$message}'"
        );
    }

    public function test_user_can_subscribe_to_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create([
            'max_subscription' => 10,
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDays(2),
        ]);

        $response = $this->actingAs($user)->post(route('events.subscribe', $event));

        if ($response->status() !== 302) {
            dump($response->getContent());
        }

        $response->assertRedirect('/');

        $response->assertSessionHas('success', 'Inscrição realizada com sucesso.');

        $this->assertDatabaseHas('event_guests', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);
    }
    public function test_user_cannot_subscribe_if_already_subscribed_to_another_event_at_same_time()
    {
        $user = User::factory()->create();

        $event1 = Event::factory()->create([
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDays(2),
            'max_subscription' => 10,
        ]);
        $event2 = Event::factory()->create([
            'starts_at' => now()->addDay()->addHours(12),
            'ends_at' => now()->addDays(3),
            'max_subscription' => 10,
        ]);

        EventGuest::factory()->create([
            'event_id' => $event1->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->post(route('events.subscribe', $event2));

        $this->assertSessionHasErrorMessage($response, 'Você já está inscrito em outro evento nesse período.');

        $this->assertDatabaseMissing('event_guests', [
            'event_id' => $event2->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_subscribe_twice_to_same_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['max_subscription' => 10]);

        EventGuest::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)->post(route('events.subscribe', $event));

        $response->assertSessionHasErrors();

        $errors = $response->baseResponse->getSession()->get('errors')->all();

        $this->assertTrue(
            in_array('Você já está inscrito em outro evento nesse período.', $errors),
            "Mensagem de erro esperada não encontrada na sessão: 'Você já está inscrito em outro evento nesse período.'"
        );
    }


    public function test_user_cannot_subscribe_if_max_subscription_reached()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['max_subscription' => 1, 'starts_at' => now()->addDay(), 'ends_at' => now()->addDays(2)]);

        EventGuest::factory()->create([
            'event_id' => $event->id,
            'user_id' => User::factory()->create()->id,
        ]);

        $response = $this->actingAs($user)->post(route('events.subscribe', $event));

        $this->assertSessionHasErrorMessage($response, 'Número máximo de participantes atingido.');

        $this->assertDatabaseMissing('event_guests', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_unsubscribe_from_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $subscription = EventGuest::factory()->create([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $response = $this->actingAs($user)->delete(route('events.unsubscribe', $event));

        $response->assertRedirect(route('events'));
        $response->assertSessionHas('success', 'Inscrição cancelada com sucesso.');

        $this->assertDatabaseHas('event_guests', [
            'user_id' => $user->id,
            'event_id' => $event->id,
        ]);

        $this->assertNotNull(
            EventGuest::withTrashed()->where('user_id', $user->id)
                ->where('event_id', $event->id)
                ->first()
                ->deleted_at
        );
    }


    public function test_owner_cannot_unsubscribe_from_own_event()
    {
        $user = User::factory()->create();

        $event = Event::factory()->create([
            'owner_id' => $user->id,
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDays(2),
        ]);

        EventGuest::factory()->create([
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->delete(route('events.unsubscribe', $event));

        $this->assertSessionHasErrorMessage($response, 'Você é o criador deste evento e não pode cancelar sua própria inscrição.');

        $this->assertDatabaseHas('event_guests', [
            'event_id' => $event->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_user_cannot_unsubscribe_if_not_subscribed()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['owner_id' => User::factory()->create()->id]);

        $response = $this->actingAs($user)->delete(route('events.unsubscribe', $event));

        $this->assertSessionHasErrorMessage($response, 'Você não está inscrito neste evento.');
    }
}
