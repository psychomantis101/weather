<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Weather
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div>WEATHER: <a href="{{route('weather.index')}}" class="g-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6 mb-6">Weather</a></div>
                    <br>
                    <div>JOIN MAIL: <a href="{{route('emailOptIn.index')}}" class="g-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6">Join Mail</a></div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
