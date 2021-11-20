<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foods') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-12 max-w-xl mx-auto divide-y md:max-w-4xl">
                    <h2 class="text-2xl font-bold">{{ $food->name }}</h2>
                    <div class="pt-4 mt-8 max-w-md">
                        <a href="{{route('foods.edit', $food)}}"
                                 class="py-2 px-4 bg-blue-400 hover:bg-blue-600 rounded-lg text-white"
                            >
                            @lang('Edit')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
