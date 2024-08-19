<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <h1 class="text-white">Crear Cliente</h1>

                <form method="POST" action="{{ route('clients.store') }}">
                    @csrf

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('Nombre')" />
                            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name"
                                value="{{ old('first_name') }}" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Apellido')" />
                            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                value="{{ old('last_name') }}" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="dni" :value="__('DNI')" />
                            <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni"
                                value="{{ old('dni') }}" required />
                            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="gas_quality_id" :value="__('Calidad de Gas')" />
                            <select id="gas_quality_id" name="gas_quality_id" class="block mt-1 w-full" required>
                                <option value="">Seleccione Calidad de Gas</option>
                                @foreach($gasQualities as $gasQuality)
                                <option value="{{ $gasQuality->id }}" {{ old('gas_quality_id')==$gasQuality->id ?
                                    'selected' : '' }}>
                                    {{ $gasQuality->name }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('gas_quality_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="provider_id" :value="__('Proveedor')" />
                            <select id="provider_id" name="provider_id" class="block mt-1 w-full" required>
                                <option value="">Seleccione Proveedor</option>
                                @foreach($providers as $provider)
                                <option value="{{ $provider->id }}" {{ old('provider_id')==$provider->id ? 'selected' :
                                    '' }}>
                                    {{ $provider->company_name }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('provider_id')" class="mt-2" />
                        </div>

                        <x-text-input id="registration_date" class="block mt-1 w-full" type="hidden"
                            name="registration_date" value="{{ date('Y-m-d')  }}" required />

                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Crear Cliente') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>