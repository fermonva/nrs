<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepositoryInterface;
use App\Repositories\GasQualityRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    private ClientRepositoryInterface $clientRepositoryInterface;
    private ProviderRepositoryInterface $providerRepositoryInterface;
    private GasQualityRepositoryInterface $gasQualityRepositoryInterface;

    public function __construct(ClientRepositoryInterface $clientRepositoryInterface, ProviderRepositoryInterface $providerRepositoryInterface, GasQualityRepositoryInterface $gasQualityRepositoryInterface)
    {
        $this->clientRepositoryInterface     = $clientRepositoryInterface;
        $this->providerRepositoryInterface   = $providerRepositoryInterface;
        $this->gasQualityRepositoryInterface = $gasQualityRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Renderable
    {
        $clients                   = $this->clientRepositoryInterface->getAllClients();
        $clientsWithNegativeProfit = $this->clientRepositoryInterface->getClientsWithNegativeProfit();
        return view('clients.index', compact('clients', 'clientsWithNegativeProfit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        $providers    = $this->providerRepositoryInterface->getAllProviders();
        $gasQualities = $this->gasQualityRepositoryInterface->getAllGasQualities();
        return view('clients.create', compact('providers', 'gasQualities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        try {
            $this->clientRepositoryInterface->createClient($request->validated());

            return redirect()->route('clients.index')->with('success', 'Client created successfully');
        } catch (\Throwable $e) {
            Log::error('Error creating client: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Error creating client');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Renderable
    {
        $client = $this->clientRepositoryInterface->getClientById($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client): Renderable
    {
        $client       = $this->clientRepositoryInterface->getClientById($client->id);
        $providers    = $this->providerRepositoryInterface->getAllProviders();
        $gasQualities = $this->gasQualityRepositoryInterface->getAllGasQualities();
        return view('clients.edit', compact('client', 'providers', 'gasQualities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client): RedirectResponse
    {
        try {
            $this->clientRepositoryInterface->updateClient($client, $request->validated());

            return redirect()->route('clients.index')->with('success', 'Client updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating client: ' . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Error updating client');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $this->clientRepositoryInterface->deleteClient($client);
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully');
    }

    public function export()
    {
        return Excel::download(new ClientsExport(), 'clientes.xlsx');
    }
}
