<?php

namespace App\Http\Controllers;

use App\Exports\ProvidersExport;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use App\Repositories\ProviderRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ProviderController extends Controller
{
    private ProviderRepositoryInterface $providerRepositoryInterface;

    public function __construct(ProviderRepositoryInterface $providerRepositoryInterface)
    {
        $this->providerRepositoryInterface = $providerRepositoryInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = $this->providerRepositoryInterface->getAllProviders();
        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProviderRequest $request)
    {
        try {
            $this->providerRepositoryInterface->createProvider($request->validated());

            return redirect()->route('providers.index')->with('success', 'Provider created successfully');
        } catch (\Throwable $e) {
            Log::error('Error creating provider: ' . $e->getMessage());
            return redirect()->route('providers.index')->with('error', 'Error creating provider');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProviderRequest $request, Provider $provider)
    {
        try {
            $this->providerRepositoryInterface->updateProvider($provider, $request->validated());

            return redirect()->route('providers.index')->with('success', 'Provider updated successfully');
        } catch (\Exception $e) {
            Log::error('Error updating provider: ' . $e->getMessage());
            return redirect()->route('providers.index')->with('error', 'Error updating provider');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $this->providerRepositoryInterface->deleteProvider($provider);
        return redirect()->route('providers.index')->with('success', 'Provider deleted successfully');
    }

    public function export()
    {
        return Excel::download(new ProvidersExport(), 'proveedores.xlsx');
    }
}
