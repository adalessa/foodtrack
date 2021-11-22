<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-12 max-w-xl mx-auto divide-y md:max-w-4xl lg:max-w-full px-2 lg:px-4">
                    <h2 class="text-2xl font-bold">{{__('Your Foods')}}</h2>
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-7 gap-2">
                        <div class="hidden md:inline">@lang('Monday')</div>
                        <div class="hidden md:inline">@lang('Tuesday')</div>
                        <div class="hidden md:inline">@lang('Wensday')</div>
                        <div class="hidden md:inline">@lang('Thursday')</div>
                        <div class="hidden md:inline">@lang('Friday')</div>
                        <div class="hidden md:inline">@lang('Saturday')</div>
                        <div class="hidden md:inline">@lang('Sunday')</div>
                        @foreach($calendar->days() as $day)
                        <div class="bg-gray-300 shadow-lg rounded-md p-4 @if($loop->first) col-start-{{$day->date()->dayOfWeek}} @endif">
                            <div class="text-sm text-center">
                                <a href="{{route('meals.create', ['date' => $day->date()->toDateString()])}}">
                                    {{$day->date()->format('d/m')}}
                                </a>
                            </div>
                            @foreach($day->meals() as $meal)
                            <div class="rounded-md bg-blue-200 p-2 shadow-lg my-2">
                                <a href="{{route('meals.edit', $meal)}}">
                                    {{__($meal->type->label)}}
                                </a>
                                <ul class="list-inside list-disc">
                                    @foreach($meal->foods as $food)
                                    <li>
                                        {{$food->name}}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
