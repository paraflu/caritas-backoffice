<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pacco spesa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="w-full" id="index">
                    <warehouse-list>
                    </warehouse-list>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        @vite('resources/js/warehouse.js')
    @endpush
</x-app-layout>
