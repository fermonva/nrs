<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <div class="flex items-center justify-end mt-4 gap-2">
                    <a href="{{ route('clients.create') }}" class="ml-4">
                        <x-primary-button>
                            Agregar cliente
                        </x-primary-button>
                    </a>
                    <a href="{{ route('clients.export') }}" class="ml-4">
                        <x-primary-button>
                            Exportar a Excel
                        </x-primary-button>
                    </a>
                </div>

                @if($clientsWithNegativeProfit->isNotEmpty())
                <div class="alert alert-danger">
                    <h4>Warning! Negative Profit Margin</h4>
                    <ul>
                        @foreach($clientsWithNegativeProfit as $client)
                        <li>
                            <strong>{{ $client->FullName }}</strong> has a negative profit
                            margin.
                            <a href="{{ route('clients.edit', $client->client_id) }}"
                                class="btn btn-warning btn-sm">Editar</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <table class="items-center bg-transparent w-full border-collapse">
                    <thead>
                        <tr>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Nombre</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Calidad del gas</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Proveedor</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Precio de compra</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Precio de venta</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Beneficio</th>
                            <th
                                class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-white border-gray-100">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->full_name }}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->gas_quality_name}}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->company_name }}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->gas_quality_price }}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->sale_price }}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                {{ $client->profit }}</td>
                            <td
                                class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center text-white">
                                <a href="{{ route('clients.edit', $client->client_id) }}"
                                    class="btn btn-warning">Editar</a> |
                                <form action="{{ route('clients.destroy', $client->client_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Controles de paginación --}}
                <div class="mt-4">
                    {{ $clients->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
