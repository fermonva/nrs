<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <h1 class="text-white">Agregar Cliente</h1>

                <form method="POST" action="{{ route('clients.store') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{ old('last_name') }}" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gas_quality_id" :value="__('Gas Quality')" />
                            <select id="gas_quality_id" name="gas_quality_id" class="block mt-1 w-full" required>
                                <option value="">Select Gas Quality</option>
                                @foreach($gasQualities as $gasQuality)
                                    <option value="{{ $gasQuality->id }}" {{ old('gas_quality_id') == $gasQuality->id ? 'selected' : '' }}>
                                        {{ $gasQuality->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('gas_quality_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="provider_id" :value="__('Provider')" />
                            <select id="provider_id" name="provider_id" class="block mt-1 w-full" required>
                                <option value="">Select Provider</option>
                                @foreach($providers as $provider)
                                    <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
                                        {{ $provider->company_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('provider_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                            <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" name="purchase_price" value="{{ old('purchase_price') }}" required />
                            <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sale_price" :value="__('Sale Price')" />
                            <x-text-input id="sale_price" class="block mt-1 w-full" type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" required />
                            <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Create Client') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>