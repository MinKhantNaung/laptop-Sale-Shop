@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('style')
    <!-- Map Picker leaflet.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.5.1/leaflet.css"
        integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
    <div class="col-12 my-4">
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
        <input type="number" class="lat" value="21.976318" />
        <input type="nummber" class="long" value="96.091253">
        <div id="myMap" class="w-100"></div>
        <!-- Map Picker End -->
        <!-- Message section -->
        <div class="row my-3">
            <div class="col-md-10 offset-md-1 mt-sm-0 mt-5 mb-5">
                <h1 class="fw-bolder text-center mb-5 border-bottom border-3 pb-3">
                    Leave Message
                </h1>
                <form id="contactForm" method="GET">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input type="text" id="name" placeholder="Your name" class="form-control py-3">
                            <div id="nameError" class="text-danger mb-3"></div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <input type="email" id="email" placeholder="Your email" class="form-control py-3">
                            <div id="emailError" class="text-danger mb-3"></div>
                        </div>
                        <div class="col-12">
                            <textarea id="message" class="form-control" placeholder="Your message" rows="6"></textarea>
                            <div id="messageError" class="text-danger mb-3"></div>
                        </div>
                        <div class="col-12 text-center">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-danger text-white rounded-0 p-3">
                                    Login first to message
                                </a>
                            @endguest
                            @auth
                                <button type="submit" class="btn btn-info text-white rounded-0 p-3">SEND
                                    MESSAGE</button>
                            @endauth
                        </div>
                    </div>
                </form>
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
                icon: '<img src="https://imgv3.fotor.com/images/blog-cover-image/part-blurry-image.jpg">',
                // initial zoom level
                zoom: 15,
                // zoom level at which the layer is visible
                limitZoom: 18,
            });
            // Map Picker end

            // contact form
            $('#contactForm').submit(function(e) {
                e.preventDefault();
                let name = $('#name');
                let email = $('#email');
                let message = $('#message');

                // for show error
                const nameError = $('#nameError');
                const emailError = $('#emailError');
                const messageError = $('#messageError');

                $.ajax({
                    type: "get",
                    url: "{{ route('contact.messageAccept') }}",
                    data: {
                        'name': name.val(),
                        'email': email.val(),
                        'message': message.val()
                    },
                    dataType: "json",
                    success: function(response) {
                        // show error messages start
                        if (response.message == 'error') {
                            if(response.error.name) {
                                nameError.text(`${response.error.name}`);
                                name.addClass('is-invalid');
                            } else {
                                nameError.text('');
                                name.removeClass('is-invalid');
                            }
                            if (response.error.email) {
                                emailError.text(`${response.error.email}`);
                                email.addClass('is-invalid');
                            } else {
                                emailError.text('');
                                email.removeClass('is-invalid');
                            }
                            if(response.error.message) {
                                messageError.text(`${response.error.message}`);
                                message.addClass('is-invalid');
                            } else {
                                messageError.text('');
                                message.removeClass('is-invalid');
                            }
                            // show error messsages end
                        } else if (response.message == 'invalid') {
                            email.addClass('is-invalid');
                            name.removeClass('is-invalid');
                            message.removeClass('is-invalid');
                            // not show error messages
                            nameError.text('');
                            emailError.text('');
                            messageError.text('');
                            return swal('Oops!', `${response.error}`,
                                'warning');
                        } else {
                            // success
                            email.removeClass('is-invalid');
                            $('#contactForm')[0].reset();
                            return swal('Thank You', `${response.message}`, 'success');
                        }
                    }
                });
            })
        });
    </script>
@endsection
