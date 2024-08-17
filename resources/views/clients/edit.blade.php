<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="$client->first_name" required autofocus />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="$client->last_name" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="dni" :value="__('DNI')" />
                        <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="$client->dni" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="provider_id" :value="__('Provider')" />
                        <select id="provider_id" name="provider_id" class="block mt-1 w-full">
                            @foreach($providers as $provider)
                                <option value="{{ $provider->id }}" {{ $client->providers->contains($provider->id) ? 'selected' : '' }}>
                                    {{ $provider->company_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="gas_quality_id" :value="__('Gas Quality')" />
                        <select id="gas_quality_id" name="gas_quality_id" class="block mt-1 w-full">
                            @foreach($gasQualities as $quality)
                                <option value="{{ $quality->id }}" {{ $client->providers->first()->pivot->gas_quality_id == $quality->id ? 'selected' : '' }}>
                                    {{ $quality->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                        <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" name="purchase_price" :value="$client->providers->first()->pivot->purchase_price" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="sale_price" :value="__('Sale Price')" />
                        <x-text-input id="sale_price" class="block mt-1 w-full" type="number" step="0.01" name="sale_price" :value="$client->providers->first()->pivot->sale_price" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Save Changes') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>