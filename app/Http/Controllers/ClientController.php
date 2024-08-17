<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\GasQualityRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private ClientRepositoryInterface $clientRepositoryInterface;
    private ProviderRepositoryInterface $providerRepositoryInterface;
    private GasQualityRepositoryInterface $gasQualityRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface, ProviderRepositoryInterface $providerRepositoryInterface, GasQualityRepositoryInterface $gasQualityRepositoryInterface)
    {
        $this->clientRepositoryInterface = $clientRepositoryInterface;
        $this->providerRepositoryInterface = $providerRepositoryInterface;
        $this->gasQualityRepositoryInterface = $gasQualityRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = $this->clientRepositoryInterface->getAllClients();
        $clientsWithNegativeProfit = $this->clientRepositoryInterface->getClientsWithNegativeProfit();
        return view('clients.index', compact('clients', 'clientsWithNegativeProfit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $this->clientRepositoryInterface->createClient($request->validated());
        return redirect()->route('clients.index')->with('success', 'Client created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = $this->clientRepositoryInterface->getClientById($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $providers = $this->providerRepositoryInterface->getAllProviders();
        $gasQualities = $this->gasQualityRepositoryInterface->getAllGasQualities();
        return view('clients.edit', compact('client', 'providers', 'gasQualities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $this->clientRepositoryInterface->updateClient($client, $request->validated());
        return redirect()->route('clients.index')->with('success', 'Client updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $this->clientRepositoryInterface->deleteClient($client);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
    }
}
