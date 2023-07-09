<h1>Here is your daily weather report for your favorite listed locations</h1>

@isset($locations)
    @foreach($locations as $location)
        <h2>{{$location['name']}}</h2>
        <p>{{$location['date']}}</p>
        <p>{{$location['description']}}</p>
        <p>{{$location['temp']}}</p>
        <p>{{$location['feels_like']}}</p>
    @endforeach
@else
    <p>Sorry, you have no saved favorite locations, why not add some?</p>
@endisset

