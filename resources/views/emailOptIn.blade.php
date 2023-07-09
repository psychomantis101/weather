<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Email
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Do you wish to opt into weather emails?</h1>
                    <div>
                        <form action="{{route('emailOptIn.optIn')}}" method="POST">
                            @csrf
                            <select name="optIn">
                                <option value="1" {{$optIn === 1 ? 'selected' : ''}}>Yes</option>
                                <option value="0" {{$optIn === 0 ? 'selected' : ''}}>No</option>
                            </select>
                            <button class="g-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow mt-6" type="submit">Submit</button>
                        </form>
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
