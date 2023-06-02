<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- fontawesome css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">
    @yield('style')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <section id="header">
                    <div class="row">
                        <div class="col-12">
                            <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
                                <div class="container">
                                    <a class="navbar-brand fw-bolder fs-3" href="#">MM-LAPTOPS</a>
                                    <a href="" class="text-black fs-6 p-0 position-relative"
                                        title="No items in the cart">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="badge bg-info position-absolute top-0 rounded-circle">0</span>
                                    </a>
                                    <a href="" class="text-black fs-6 ps-2 ps-sm-0 ps-lg-5 position-relative"
                                        title="No orders in the checkout">
                                        <i class="fa-solid fa-basket-shopping"></i>
                                        <span class="badge bg-info position-absolute top-0 rounded-circle">0</span>
                                    </a>
                                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                                        aria-label="Toggle navigation">
                                        <span class="navbar-toggler-icon"></span>
                                    </button>
                                    <div class="collapse navbar-collapse d-lg-flex justify-content-center align-items-center"
                                        id="navbarNav">
                                        <ul class="navbar-nav mx-auto">
                                            <li class="nav-item">
                                                <a class="nav-link fw-bold px-4" href="{{ route('home') }}">HOME</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link fw-bold px-4" href="{{ route('shop') }}">SHOP</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link fw-bold px-4" href="#">BLOG</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link fw-bold px-4" href="">CONTACT</a>
                                            </li>
                                        </ul>
                                        <!-- Guest -->
                                        @guest
                                            <ul class="navbar-nav">
                                                <li class="nav-item">
                                                    <a class="nav-link fw-bold px-4" href="{{ route('login') }}">
                                                        <i class="fa-solid fa-user"></i>&nbsp;
                                                        Login
                                                    </a>
                                                </li>
                                            </ul>
                                        @endguest
                                        <!-- Auth -->
                                        @auth
                                            <ul class="navbar-nav">
                                                <li class="nav-item dropdown">
                                                    <a class="nav-link dropdown-toggle fw-bold px-4" href="#"
                                                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <img @if (auth()->user()->gender == 'male') src="{{ asset('images/default_profile.webp') }}" @else src="{{ asset('images/default_female.jpg') }}" @endif
                                                            style="width:50px;height:50px" alt="User Profile Image"
                                                            class="img-fluid object-fit-cover rounded-circle">
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fa-solid fa-user-tie"></i> &nbsp;
                                                                {{ auth()->user()->name }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="fa-solid fa-key"></i> &nbsp;
                                                                Change Password
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form id="myForm" method="POST"
                                                                action="{{ route('logout') }}">
                                                                @csrf
                                                            </form>
                                                            <a class="dropdown-item" href="#" onclick="submitForm()">
                                                                <i class="fa-solid fa-arrow-right-from-bracket"></i> &nbsp;
                                                                Logout
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endauth
                                    </div>
                                </div>
                            </nav>
                            <img src="{{ asset('images/laptop_home.jpg') }}" alt="image"
                                class="w-100 img-fluid object-fit-cover" id="respon-img">
                            <div class="col-md-6 offset-md-3" id="searchBar">
                                <form action="{{ route('shop.search') }}" method="GET">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="fa-solid fa-magnifying-glass"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control bg-light py-2"
                                            placeholder="Search laptops">
                                        <select name="brand_id">
                                            <option value="">Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>

                                        <button type="submit" class="btn btn-info ms-3">Search</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </section>

                <section id="main">
                    <div class="container">
                        <div class="row">
                            @yield('content')
                        </div>
                    </div>
                </section>

                <!-- Footer Section -->
                <section id="footer" class="bg-secondary-subtle">
                    <div class="container">
                        <div class="row text-black mt-3">
                            <div class="col-md-3 col-sm-6 py-sm-5 py-3">
                                <a href=""
                                    class="navbar-brand fw-bolder fs-4 text-decoration-none text-uppercase text-black">MM
                                    Laptops
                                </a>
                                <p class="mt-3 text-muted">Address: TharkayTa-Road, Yangon <br>
                                    Phone: 09 258 138 856 <br>
                                    Email: hello@gmail.com
                                </p>
                            </div>
                            <div class="col-md-3 col-sm-6 py-sm-5 py-3">
                                <h5 class="mb-3">About us</h5>
                                <div class="text-muted">We learn</div>
                                <div class="text-muted">We share</div>
                                <div class="text-muted">We code</div>
                                <div class="text-muted">We care environment</div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-sm-5 py-3">
                                <h5 class="mb-3">Product</h5>
                                <div class="text-muted">Main Sponser</div>
                                <div class="text-muted">Aung Bann</div>
                                <div class="text-muted">Transportation</div>
                                <div class="text-muted">Shopify</div>
                            </div>
                            <div class="col-md-3 col-sm-6 py-sm-5 py-3">
                                <h5 class="mb-3">Contact Us</h5>
                                <div class="text-muted">hello@minnaungweb.com</div>
                                <div class="text-muted">+95 -258138866</div>
                                <div class="mt-1">
                                    <a href=""
                                        class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                            class="fa-brands fa-facebook-f"></i></a>
                                    <a href=""
                                        class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                            class="fa-brands fa-instagram"></i></a>
                                    <a href=""
                                        class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                            class="fa-brands fa-telegram"></i></a>
                                    <a href=""
                                        class="btn btn-sm text-black rounded-circle bg-white me-1 link-hover"><i
                                            class="fa-brands fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- sub-footer section -->
                <section class="bg-white">
                    <div class="container">
                        <div class="row py-4">
                            <div class="col-12 d-flex justify-content-between">
                                <div class="text-muted">&copy; 2022 Energitic Themes</div>
                                <div class="text-muted">
                                    <span>Privacy Policy</span>
                                    <span>Terms & Conditions</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
<!-- jquery js -->
<script src="{{ asset('assets/jquery.min.js') }}"></script>
<!-- axios js -->
<script src="{{ asset('assets/axios.min.js') }}"></script>
<!-- fontawesome js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
    integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
{{-- Sweet Alert --}}
<script src="{{ asset('assets/sweetalert.min.js') }}"></script>
<!-- Custom js -->
<script src="{{ asset('assets/custom.js') }}"></script>

{{-- for logout form --}}
<script>
    function submitForm() {
        if (confirm('Sure to logout?')) {
            document.querySelector('#myForm').submit();
        }
    }
</script>
@yield('script')

</html>
