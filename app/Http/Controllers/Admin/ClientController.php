<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Services\ActivityLogService;

class ClientController extends Controller
{
    public function __construct(private readonly ActivityLogService $activityLog)
    {
    }

    public function index()
    {
        return view('admin.clients.index', [
            'clients' => Client::query()->latest()->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.clients.create', ['client' => new Client()]);
    }

    public function store(StoreClientRequest $request)
    {
        $client = Client::query()->create($request->validated());
        $this->activityLog->log('clients', 'create', 'Client ajoute: '.$client->nom, $client);

        return redirect()->route('admin.clients.index')->with('success', 'Client ajoute avec succes.');
    }

    public function show(Client $client)
    {
        return redirect()->route('admin.clients.edit', $client);
    }

    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());
        $this->activityLog->log('clients', 'update', 'Client mis a jour: '.$client->nom, $client);

        return redirect()->route('admin.clients.index')->with('success', 'Client mis a jour.');
    }

    public function destroy(Client $client)
    {
        $this->activityLog->log('clients', 'delete', 'Client supprime: '.$client->nom, $client);
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client supprime.');
    }
}
