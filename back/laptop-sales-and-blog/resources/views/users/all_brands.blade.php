@extends('users.layouts.master')

@section('title', 'MM Laptops-Shop')

@section('content')
    <div class="col-12 my-4">
        <!-- All Brands Section -->
        <section id="category">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h5>All Brands
                    </h5>
                    <div class="row my-sm-5">
                        @foreach ($brands as $brand)
                            <div class="col-lg-2 col-sm-3 col-4 mt-2">
                                <a href="">
                                    <div class="p-2 position-relative" style="height:120px; background: rgb(220, 231, 231);">
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            <div style="width:40px;height:40px">
                                                <img src="{{ asset('storage/brand_images/' . $brand->image) }}"
                                                    alt="image"
                                                    class="w-100 img-fluid object-fit-cover rounded-circle ms-2"
                                                    style="height:100%">
                                            </div>
                                            <div class="text-muted text-center fs-6 text-capitalize">
                                                {{ $brand->name }}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
