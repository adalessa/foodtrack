<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-12 max-w-xl mx-auto divide-y md:max-w-4xl">
                    <h2 class="text-2xl font-bold">{{__('Create Meal')}}</h2>
                    <div class="mt-8 max-w-md">
                        <form action="{{route('meals.update', $meal)}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-6">
                                <label class="block">
                                    <span class="text-gray-700">@lang("Date")</span>
                                    <input type="date" name="date" value="{{old('date', $meal->date->toDateString())}}" class="
                                                 mt-0
                                                 block
                                                 w-full
                                                 px-0.5
                                                 border-0 border-b-2 border-gray-200
                                                 focus:ring-0 focus:border-black
                                                 ">
                                </label>
                                <label class="block">
                                    <span class="text-gray-700">@lang('Type')</span>
                                    <select name="type" class="
                                                   block
                                                   w-full
                                                   mt-0
                                                   px-0.5
                                                   border-0 border-b-2 border-gray-200
                                                   focus:ring-0 focus:border-black
                                                   ">
                                        @foreach($types as $type)
                                            <option value="{{$type->value}}"  @if(old('type', $meal->type->value) == $type->value) selected @endif >@lang($type->label) </option>
                                        @endforeach
                                    </select>
                                </label>
                                <label class="block" x-data="{ foods: {{$meal->foods->pluck('id')}} }">
                                    <div class="flex justify-between">
                                        <span class="text-gray-700">@lang('Food')</span>
                                        <div>
                                            <template x-if="foods.length > 1">
                                                <button x-on:click="foods.pop()" type="button" class="bg-red-300 rounded-full px-2 text-white">-</button>
                                            </template>
                                            <button x-on:click="foods.push(0)" type="button" class="bg-green-300 rounded-full px-2 text-white">+</button>
                                        </div>
                                    </div>
                                    <template x-for="food in foods">
                                        <select x-model="food"  name="foods[]" class="
                                                       block
                                                       w-full
                                                       mt-0
                                                       px-0.5
                                                       border-0 border-b-2 border-gray-200
                                                       focus:ring-0 focus:border-black
                                                       ">
                                            @foreach($foods as $food)
                                                <option value="{{$food->id}}">@lang($food->name) </option>
                                            @endforeach
                                        </select>
                                    </template>
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
