@extends('layouts.default')

@section('title', 'Properties')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div id="form" class="row">
        <form method="get" action="{{ route('search') }}">

            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" value="@isset($filter['location']){{ $filter['location'] }}@endisset">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="availabilityFrom">Availability From</label>
                        <input type="text"
                               id="availabilityFrom"
                               name="availabilityFrom"
                               placeholder="dd/mm/yyyy"
                               value="@isset($filter['availabilityFrom']){{ $filter['availabilityFrom'] }} @endisset"
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
                               value="@isset($filter['availabilityTo']){{ $filter['availabilityTo'] }}@endisset"
                        >
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label for="sleeps">Sleeps</label>
                        <input type="text" id="sleeps" name="sleeps" value="@isset($filter['sleeps']){{ $filter['sleeps'] }}@endisset">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="beds">Beds</label>
                        <input type="text" id="beds" name="beds" value="@isset($filter['beds']){{ $filter['beds'] }}@endisset">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="acceptsPets">Pets</label>
                        <input type="checkbox" id="acceptsPets" name="acceptsPets" value="1" @isset($filter['acceptsPets'])checked='checked'@endisset">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="nearBeach">Near Beach</label>
                        <input type="checkbox" id="nearBeach" name="nearBeach" value="1" @isset($filter['nearBeach']) checked="checked" @endisset}}">
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
            @if(!isset($result) || $result === null)
                <div class="row">
                    <div class="col-md-12">
                        <p>No properties found!</p>
                    </div>
                </div>
            @else
                {{ $result->appends($filter)->links() }}
                @foreach($result as $property)
                    <div class="row">
                        <div class="col-md-4">{{ $property->property_name }}</div>
                        <div class="col-md-2">{{ $property->sleeps }}</div>
                        <div class="col-md-2">{{ $property->beds }}</div>
                        <div class="col-md-2">{{ $property->accepts_pets }}</div>
                        <div class="col-md-2">{{ $property->near_beach }}</div>
                    </div>
                @endforeach
            @endempty
        </div>
    </div>
@endsection