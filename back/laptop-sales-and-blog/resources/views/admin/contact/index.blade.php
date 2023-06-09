@extends('admin.layouts.master')

@section('title', 'Admin Dashboard-Messages')

@section('style')
    <!-- Map Picker leaflet.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800 col-12">
                Contact
            </h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Table -->
            <div class="card shadow mb-4 col-12">
                {{-- alert messages --}}
                @if (session('success'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-info alert-dismissible fade show mt-1" role="alert">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-warning alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('danger'))
                    <div class="col-12 col-sm-6 col-md-4 alert alert-danger alert-dismissible fade show mt-1"
                        role="alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('danger') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- alert messages end --}}
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Our Contact
                        <a href="" class="btn btn-info float-end">
                            <i class="fa-solid fa-location-crosshairs me-1"></i>Create
                        </a>
                    </h6>
                </div>
                <div class="card-body">
                    <!-- contact section -->
                    <div class="row my-3">
                        <div class="col-12 col-sm-6 col-md-3 text-center my-3">
                            <i class="fa-solid fa-phone text-info fs-2"></i> <br>
                            <h4 class="fw-bold mt-3">Phone</h4>
                            <p>09 258 128 856</p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 text-center my-3">
                            <i class="fa-solid fa-location-dot text-info fs-2"></i> <br>
                            <h4 class="fw-bold mt-3">Address</h4>
                            <p>63-69 road, Mandalay</p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 text-center my-3">
                            <i class="fa-regular fa-clock text-info fs-2"></i> <br>
                            <h4 class="fw-bold mt-3">Open Time</h4>
                            <p>10:00 am to 20:00 am</p>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 text-center my-3">
                            <i class="fa-regular fa-envelope text-info fs-2"></i> <br>
                            <h4 class="fw-bold mt-3">Email</h4>
                            <p>hello@gmail.com</p>
                        </div>
                    </div>
                    <!-- Map Picker Start -->
                    <input type="number" class="lat" value="21.976318" disabled />
                    <input type="nummber" class="long" value="96.091253" disabled>
                    <div id="myMap" class="w-100"></div>
                    <!-- Map Picker End -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Map Picker leaflet.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.js"
        integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- leaflet am map -->
    <script src="{{ asset('assets/leaflet/am_map.js') }}"></script>
    <script>
        $(document).ready(function() {
            let lati = Number($('.lat').val());
            let long = Number($('.long').val());

            let map = $("#myMap").am_map({
                // center of the map
                center: [lati, long],
                // map height
                height: '400px',
                background: 'osm',
            });

            $("#myMap").am_map('addLayer', {
                // unique name
                name: 'iconLayer',
                // marker point
                points: [lati, long],
                // custom icon HTML
                icon: '<i class="fa-solid fa-location-dot text-success" style="font-size:50px"></i>',
                // initial zoom level
                zoom: 15,
                // zoom level at which the layer is visible
                limitZoom: 8,
            });
            // Map Picker end
        });
    </script>
@endsection
