<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Provider') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg space-y-6">
                <h1 class="text-white">Editar Proveedor</h1>

                <form method="POST" action="{{ route('providers.update', $provider->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="company_name" :value="__('Nombre Proveedor')" />
                            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name"
                                value="{{ $provider->company_name }}" required autofocus />
                        </div>

                        <div>
                            <x-input-label for="country" :value="__('Pais')" />
                            <x-text-input id="country" class="block mt-1 w-full" type="text" name="country"
                                value="{{ $provider->country }}" required />
                        </div>

                        <div>
                            <x-input-label for="cif" :value="__('CIF')" />
                            <x-text-input id="cif" class="block mt-1 w-full" type="text" name="cif"
                                value="{{ $provider->cif }}" required />
                        </div>
                    </div>

                    <x-text-input id="registration_date" class="block mt-1 w-full" type="hidden" step="0.01"
                        name="registration_date" value="{{ date('Y-m-d') }}" />


                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Atualizar Proveedor') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>