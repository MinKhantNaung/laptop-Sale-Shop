@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Contact')
@section('style')
    <!-- Map Picker leaflet.css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <!-- Map Picker from dist -->
    <link rel="stylesheet" href="{{ asset('assets/dist/leaflet-locationpicker.src.css') }}" />
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Contact
    </h1>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Create Contact</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.createContact') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="number" name="phone" id="phone"
                                class="form-control mt-2 @error('phone') is-invalid @enderror"
                                placeholder="Office phone number" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Office email"
                                value="{{ old('email') }}" class="form-control mt-2 @error('email') is-invalid @enderror"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" placeholder="Office location"
                                class="form-control mt-2 @error('address') is-invalid @enderror" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="open_time">Open Time</label>
                            <input type="time" id="open_time" name="open_time" value="{{ old('open_time') }}"
                                class="form-control @error('open_time') is-invalid @enderror" required>
                            @error('open_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="close_time">Close Time</label>
                            <input type="time" id="close_time" name="close_time" value="{{ old('close_time') }}"
                                class="form-control @error('close_time') is-invalid @enderror" required>
                            @error('close_time')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Map Picker Start -->
                        <input type="hidden" name="coordinates" value="21.982316,96.179738" class="example"/>
                        <div id="mapContainer" class="w-100" style="height: 400px"></div>
                        <!-- Map Picker End -->
                        <a href="{{ route('admin.contact') }}" class="btn btn-secondary mt-2">Cancel</a>
                        <button type="submit" class="btn btn-info text-light mt-2">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('script')
    <!-- Map Picker leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <!-- Map Picker from dist -->
    <script src="{{ asset('assets/dist/leaflet-locationpicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.example').leafletLocationPicker({
                alwaysOpen: true,
                mapContainer: "#mapContainer",
                position: 'bottomleft',
                height: 400,
            });
        })
    </script>
@endsection
