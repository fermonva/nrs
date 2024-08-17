<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <div class="flex justify-between items-center">
                    <h1>Clients</h1>
                    <a href="{{ route('clients.create') }}" class="btn btn-primary">Add Client</a>
                </div>

                @if($clientsWithNegativeProfit->isNotEmpty())
                    <div class="alert alert-danger">
                        <h4>Warning! Negative Profit Margin</h4>
                        <ul>
                            @foreach($clientsWithNegativeProfit as $client)
                                <li>
                                    <strong>{{ $client->first_name }} {{ $client->last_name }}</strong> has a negative profit margin.
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table class="items-center bg-transparent w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Name</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">DNI</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Provider</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Gas Quality</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Purchase Price</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Sale Price</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Profit</th>
                            <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-gray-50 dark:bg-gray-700 text-gray-500 border-gray-100">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $client->first_name }} {{ $client->last_name }}</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $client->dni }}</td>
                                    @foreach($client->providers as $provider)
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $provider->company_name }}</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $provider->pivot->gas_quality_id }}</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $provider->pivot->purchase_price }}</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $provider->pivot->sale_price }}</td>
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">{{ $provider->pivot->sale_price - $provider->pivot->purchase_price }}</td>
                                    @endforeach
                                <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-center">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Edit</a> |
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>