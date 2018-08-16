@extends('layouts.default')

@section('title', 'Properties')

@section('sidebar')
    @parent

    <p>This is appended to the master sidebar.</p>
@endsection

@section('content')
    <div class="container">
    <div id="form" class="row">
        <form method="post" action="{{ route('search') }}">
            @csrf
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="availabilityFrom">Availability From</label>
                        <input type="text"
                               id="availabilityFrom"
                               name="availabilityFrom"
                               placeholder="dd/mm/yyyy"
                               value="{{ old('availabilityFrom') }}"
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="availabilityTo">Availability To</label>
                        <input type="text"
                               id="availabilityTo"
                               name="availabilityTo"
                               placeholder="dd/mm/yyyy"
                               value="{{ old('availabilityTo') }}"
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="sleeps">Sleeps</label>
                        <input type="text" id="sleeps" name="sleeps" value="{{ old('sleeps') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="beds">Beds</label>
                        <input type="text" id="beds" name="beds" value="{{ old('beds') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="acceptsPets">Pets</label>
                        <input type="checkbox" id="acceptsPets" name="acceptsPets" value="{{ old('acceptsPets') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="nearBeach">Near Beach</label>
                        <input type="checkbox" id="nearBeach" name="nearBeach" value="{{ old('nearBeach') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <input type="submit" value="Search">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">Property Name</div>
                <div class="col-md-2">Sleeps</div>
                <div class="col-md-2">Beds</div>
                <div class="col-md-2">Accepts Pets</div>
                <div class="col-md-2">Near Beach</div>
            </div>
            @isset($result)
                @foreach($result as $property)
                    <div class="row">
                        <div class="col-md-4">{{ $property->property_name }}</div>
                        <div class="col-md-2">{{ $property->sleeps }}</div>
                        <div class="col-md-2">{{ $property->beds }}</div>
                        <div class="col-md-2">{{ $property->accepts_pets }}</div>
                        <div class="col-md-2">{{ $property->near_beach }}</div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
@endsection