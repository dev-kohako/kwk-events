<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    // Constantes para valores fixos
    use AuthorizesRequests;
    protected const PAGINATION_DEFAULT = 6;

    /**
     * Exibe lista de eventos disponíveis
     */
    public function index(): Response
    {
        $events = Event::eligible()
            ->withCount(['guests'])
            ->with(['guests' => fn($q) => $q->where('user_id', Auth::id())])
            ->paginate(self::PAGINATION_DEFAULT)
            ->through(fn($event) => $this->transformEvent($event));

        return Inertia::render('Events/Index', [
            'events' => $events,
            'auth' => ['user' => Auth::user()],
        ]);
    }

    /**
     * Exibe eventos do usuário logado
     */
    public function myEvents(): Response
    {
        $events = Auth::user()->events()
            ->withCount(['guests'])
            ->latest()
            ->paginate(self::PAGINATION_DEFAULT);

        return Inertia::render('Events/MyEvents', [
            'events' => $events,
            'auth' => ['user' => Auth::user()],
        ]);
    }

    /**
     * Exibe detalhes de um evento específico
     */
    public function show(Event $event): Response
    {
        $user = Auth::user();

        return Inertia::render('Events/Show', [
            'event' => array_merge(
                $event->loadCount('guests')->toArray(),
                [
                    'is_subscribed' => $event->guests()->where('user_id', $user->id)->exists(),
                    'is_full' => $event->max_subscription &&
                        $event->guests()->count() >= $event->max_subscription,
                ]
            ),
        ]);

    }


    /**
     * Exibe formulário de criação
     */
    public function create(): Response
    {
        return Inertia::render('Events/Create');
    }

    /**
     * Armazena novo evento
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $this->validateEventRequest($request);

            $event = Event::create($this->prepareEventData($validated, true));

            $guest = $event->guests()->create(['user_id' => Auth::id()]);

            if (!$guest) {
                Log::error("Falha ao criar EventGuest");
            }



            return back()->with('success', 'Evento criado com sucesso!');
        } catch (ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Erro ao criar evento: ' . $e->getMessage());
            return Redirect::back()
                ->with('error', 'Erro inesperado ao criar evento.')
                ->withInput();
        }
    }

    /**
     * Exibe formulário de edição
     */
    public function edit(Event $event): Response
    {
        $this->authorize('update', $event);
        return Inertia::render('Events/Edit', ['event' => $event]);
    }

    /**
     * Atualiza evento existente
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        try {
            $validated = $this->validateEventRequest($request, false);

            $event->update($this->prepareEventData($validated));

            return back()->with('success', 'Evento atualizado com sucesso.');
        } catch (ValidationException $e) {
            return Redirect::back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Erro ao atualizar evento: ' . $e->getMessage());
            return Redirect::back()
                ->with('error', 'Erro inesperado ao atualizar evento.')
                ->withInput();
        }
    }

    /**
     * Remove um evento
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        try {
            $event->delete();

            return redirect()
                ->route('events.my-events')
                ->with('success', 'Evento excluído com sucesso.');
        } catch (\Throwable $e) {
            Log::error('Erro ao excluir evento: ' . $e->getMessage());
            return redirect()
                ->route('events.my-events')
                ->with('error', 'Erro inesperado ao excluir o evento.');
        }
    }


    /**
     * Transforma o modelo Event para array
     */
    protected function transformEvent(Event $event): array
    {
        return [
            'id' => $event->id,
            'uuid_code' => $event->uuid_code,
            'name' => $event->name,
            'description' => $event->description,
            'address' => $event->address,
            'complement' => $event->complement,
            'zipcode' => $event->zipcode,
            'number' => $event->number,
            'city' => $event->city,
            'state' => $event->state,
            'starts_at' => $event->starts_at,
            'ends_at' => $event->ends_at,
            'status_label' => $event->status_label,
            'max_subscription' => $event->max_subscription,
            'guests_count' => $event->guests_count,
            'guests' => $event->guests,
        ];
    }

    /**
     * Valida os dados do request
     */
    protected function validateEventRequest(Request $request, bool $isCreate = true): array
    {
        $rules = [
            'eventInfo.name' => 'required|string|max:255',
            'eventInfo.description' => 'nullable|string',

            'address.address' => 'required|string|max:255',
            'address.number' => 'required|string|max:10',
            'address.complement' => 'nullable|string|max:100',
            'address.zipcode' => 'required|string|max:20',
            'address.city' => 'required|string|max:100',
            'address.state' => 'required|string|max:2',

            'schedule.starts_at' => 'required|date',
            'schedule.starts_time' => ['required', 'regex:/^\d{2}:\d{2}$/'],
            'schedule.ends_at' => 'required|date|after_or_equal:schedule.starts_at',
            'schedule.ends_time' => ['required', 'regex:/^\d{2}:\d{2}$/'],

            'vacancy.max_subscription' => 'required|integer|min:1',
        ];

        return $request->validate($rules);
    }

    /**
     * Prepara os dados para criação/atualização
     */
    protected function prepareEventData(array $validated, bool $isCreate = false): array
    {
        $data = [
            'name' => $validated['eventInfo']['name'],
            'description' => $validated['eventInfo']['description'] ?? null,

            'address' => $validated['address']['address'],
            'number' => $validated['address']['number'],
            'complement' => $validated['address']['complement'] ?? null,
            'zipcode' => $validated['address']['zipcode'],
            'city' => $validated['address']['city'],
            'state' => strtoupper($validated['address']['state']),

            'starts_at' => $validated['schedule']['starts_at'] . ' ' . $validated['schedule']['starts_time'],
            'ends_at' => $validated['schedule']['ends_at'] . ' ' . $validated['schedule']['ends_time'],

            'max_subscription' => $validated['vacancy']['max_subscription'],
        ];

        if ($isCreate) {
            $data['uuid_code'] = Str::uuid();
            $data['owner_id'] = Auth::id();
            $data['is_active'] = true;
        }

        return $data;
    }
}