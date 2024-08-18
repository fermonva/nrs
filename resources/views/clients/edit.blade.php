<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <h1 class="text-white">Editar Cliente</h1>

                <form method="POST" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" value="{{ $client->first_name }}" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{ $client->last_name }}" required />
                        </div>

                        <div>
                            <x-input-label for="gas_quality_id" :value="__('Gas Quality')" />
                            <select id="gas_quality_id" name="gas_quality_id" class="block mt-1 w-full" required>
                                @foreach($gasQualities as $gasQuality)
                                    <option value="{{ $gasQuality->id }}" {{ $client->gas_quality_id == $gasQuality->id ? 'selected' : '' }}>
                                        {{ $gasQuality->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="gas_quality_id" :value="__('Gas Quality')" />
                            <select id="gas_quality_id" name="gas_quality_id" class="block mt-1 w-full" required>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ $client->provider_id == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->company_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                            <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" name="purchase_price" value="{{ $client->purchase_price }}" required />
                        </div>

                        <div>
                            <x-input-label for="sale_price" :value="__('Sale Price')" />
                            <x-text-input id="sale_price" class="block mt-1 w-full" type="number" step="0.01" name="sale_price" value="{{ $client->sale_price }}" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update Client') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>