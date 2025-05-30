<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventGuest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class SubscribeController extends Controller
{
    /**
     * Inscreve o usuário autenticado no evento.
     */
    public function subscribe(Event $event): RedirectResponse
    {
        $user = Auth::user();

        $isSubscribedToAnother = EventGuest::where('user_id', $user->id)
            ->whereHas('event', function ($query) use ($event) {
                $query->where('is_active', true)
                    ->where(function ($q) use ($event) {
                        $q->whereBetween('starts_at', [$event->starts_at, $event->ends_at])
                            ->orWhereBetween('ends_at', [$event->starts_at, $event->ends_at])
                            ->orWhere(function ($q2) use ($event) {
                                $q2->where('starts_at', '<=', $event->starts_at)
                                    ->where('ends_at', '>=', $event->ends_at);
                            });
                    });
            })->exists();

        if ($isSubscribedToAnother) {
            return back()->withErrors(['Você já está inscrito em outro evento nesse período.']);
        }

        if ($event->guests()->where('user_id', $user->id)->exists()) {
            return back()->withErrors(['Você já está inscrito neste evento.']);
        }

        if ($event->max_subscription && $event->guests()->count() >= $event->max_subscription) {
            return back()->withErrors(['Número máximo de participantes atingido.']);
        }

        try {
            EventGuest::create([
                'event_id' => $event->id,
                'user_id' => $user->id,
            ]);

            return redirect()->route('events')->with('success', 'Inscrição realizada com sucesso.');
        } catch (\Throwable $e) {
            Log::error('Erro ao inscrever usuário: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocorreu um erro inesperado ao tentar se inscrever.']);
        }
    }
    /**
     * Cancela a inscrição do usuário autenticado.
     */
    public function unsubscribe(Event $event): RedirectResponse
    {
        $user = Auth::user();

        if ($event->owner_id === $user->id) {
            return back()->withErrors(['Você é o criador deste evento e não pode cancelar sua própria inscrição.']);
        }

        $subscription = EventGuest::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if (!$subscription) {
            return back()->withErrors(['Você não está inscrito neste evento.']);
        }

        try {
            $subscription->delete();

            return redirect()->route('events')->with('success', 'Inscrição cancelada com sucesso.');
        } catch (\Throwable $e) {
            Log::error('Erro ao cancelar inscrição: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocorreu um erro inesperado ao tentar se inscrever.']);
        }
    }

    /**
     * Lista eventos em que o usuário está inscrito.
     */
    public function mySubscriptions(): Response
    {
        $user = Auth::user();

        $events = Event::whereHas('guests', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
            ->with('guests')
            ->latest()
            ->get();

        return Inertia::render('Subscriptions/MySubscriptions', [
            'events' => $events,
        ]);
    }
}
