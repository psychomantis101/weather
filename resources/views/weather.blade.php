{{--this is a total dogs dinner - im talking proper crap--}}
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
                    <form action="{{route('weather.index')}}" method="GET">
                        <div>
                            <label for="favoriteLocation">Favorite Locations</label>
                            <select id ="favoriteLocation">
                                <option></option>
                                @foreach($favoriteLocations as $location)
                                    <option value="{{$location->city}}">{{$location->city}} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="locationSaved" style="display: none">Location Saved</div>

                        @csrf
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Enter city" autocomplete="off" value="{{old('city')}}">
                        </div>
                        <button type="submit"
                                class="g-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6">
                            Get Weather
                        </button>

                        @if(isset($currentWeather) && $currentWeather === false)
                            <div class="mt-6">
                                <p class="text-2xl font-bold mb-2">Location not found</p>
                            </div>
                        @endif

                    </form>
                    @if(isset($currentWeather) && $currentWeather)
                        <button
                            id="saveLocation"
                            class="g-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6">
                            Save Location
                        </button>
                    @endif

                    @if(isset($currentWeather) && $currentWeather)
                        <div class="mt-6">
                            <h2 class="text-gray-800">{{$currentWeather['name']}}</h2>
                            <div class="flex">
                                <div class="mr-6 mt-6">
                                    <p class="text-2xl font-bold mb-2">{{$currentWeather['date']}}</p>
                                    <p class="text-2xl font-bold mb-2">{{$currentWeather['description']}}</p>
                                    <p class="text-2xl font-bold mb-2">{{$currentWeather['temp']}}</p>
                                    <p class="text-2xl font-bold mb-2">{{$currentWeather['feels_like']}}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        $('#saveLocation').click(function() {
            $.ajax({
                url: '{{route("location.saveFavoriteLocation")}}',
                type: 'POST',
                dataType: 'json',
                data: {'city': '{{$currentWeather['name'] ?? ''}}', "_token": "{{ csrf_token() }}"},
                success: function(response) {
                    $('.locationSaved').show();
                    $('#favoriteLocation').append('<option value="' + response.location + '">' + response.location + '</option>');
                }
            });
        });

        $('#favoriteLocation').change(function() {
           $('#city').val($(this).val());
        });
    </script>
</x-app-layout>
