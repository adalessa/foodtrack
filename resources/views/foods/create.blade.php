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
                    <h2 class="text-2xl font-bold">{{__('Create Food')}}</h2>
                    <div class="mt-8 max-w-md">
                        <form action="{{route('foods.store')}}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-6">
                                <label class="block">
                                    <span class="text-gray-700">@lang('Name')</span>
                                    <input value="{{old('name')}}" type="text" class="
                                                 mt-0
                                                 block
                                                 w-full
                                                 px-0.5
                                                 border-0 border-b-2 border-gray-200
                                                 focus:ring-0 focus:border-black
                                                 " placeholder="" name="name">
                                    @if($errors->first('name'))
                                        <div class="font-medium text-red-600">{{ $errors->first('name') }}</div>
                                    @endif
                                </label>
                                <div class="block">
                                    <div class="mt-2">
                                        <div class="flex justify-end">
                                            <button class="py-2 px-4 bg-blue-400 hover:bg-blue-600 rounded-lg text-white" type="submit">@lang('Save')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
