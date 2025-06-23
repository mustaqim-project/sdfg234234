@php
$languages = \App\Models\Language::where('status', 1)->get();
$featuredCategories = \App\Models\Category::where([
'status' => 1,
'language' => getLangauge(),
'show_at_nav' => 1,
])->get();

$categories = \App\Models\Category::where(['status' => 1, 'language' => getLangauge(), 'show_at_nav' => 0])->get();
@endphp
<style>

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        margin: -1px;
        padding: 0;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
    }


    /* CSS untuk membatasi antara kategori dengan About Us */
    .navbar-nav .nav-link[href="{{ route('about') }}"] {
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    /* CSS untuk membatasi antara Contact dengan Login */
    .navbar-nav .nav-link[href="{{ route('register') }}"] {
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    /* CSS untuk membatasi antara Contact dengan Login */
    .navbar-nav .nav-link[href="{{ route('contact') }}"] {
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    /* CSS untuk membatasi antara Login dengan link setelahnya */
    #nav-side-site-language {
        width: 100%; /* Lebar penuh */
        padding: 8px; /* Padding di dalam */
        font-size: 16px; /* Ukuran font */
        border: 1px solid #ccc; /* Garis tepi */
        border-radius: 4px; /* Sudut melengkung */
        background-color: #fff; /* Warna latar belakang */
    }

    /* CSS untuk styling opsi dalam <select> */
    #nav-side-site-language option {
        font-size: 14px; /* Ukuran font opsi */
        background-color: #fff; /* Warna latar belakang opsi */
        color: #333; /* Warna teks */
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }

    .navbar-nav .dropdown-toggle {
        border-bottom: 1px solid #ccc; /* Garis bawah */
        margin-bottom: 10px; /* Ruang kosong di bawah */
        padding-bottom: 5px; /* Padding bawah */
    }
</style>

<header class="bg-light">
    <!-- Navbar Top -->
    <div class="topbar d-none d-sm-block">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-8">
                    <div class="topbar-left topbar-right d-flex">
                        <ul class="topbar-sosmed p-0">
                            @foreach ($socialLinks as $link)
                            <li>
                                <a href="{{ $link->url }}" class="btn btn-social rounded text-white" aria-label="Go to {{ $link->icon }}">
                                    <i class="{{ $link->icon }}"></i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <div class="topbar-text">
                            {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->isoFormat('dddd, MMMM D, YYYY H:mm:ss') }} Jakarta, Indonesia
                        </div>

                    </div>
                </div>
               <div class="col-sm-6 col-md-4">
                    <div class="list-unstyled topbar-right d-flex align-items-center justify-content-end">
                        <div class="topbar_language">
                            <label for="site-language" class="sr-only">Choose Language:</label>
                            <select id="site-language">
                                @foreach ($languages as $language)
                                <option value="{{ $language->lang }}" {{ getLangauge() === $language->lang ? 'selected' : '' }}>
                                    {{ $language->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <ul class="topbar-link">
                            @if (!auth()->check())
                            <li><a href="{{ route('login') }}">{{ __('frontend.Login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ __('frontend.Register') }}</a></li>
                            @else
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <li>
                                    <a onclick="event.preventDefault(); this.closest('form').submit();" href="{{ route('logout') }}">{{ __('frontend.Logout') }}</a>
                                </li>
                            </form>

                            @endif


                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Navbar Top -->

    <!-- Navbar -->
    <!-- Navbar menu -->
    <div class="navigation-wrap navigation-shadow bg-white">
        <nav class="navbar navbar-hover navbar-expand-lg navbar-soft">
            <div class="container">
                <div class="offcanvas-header">
                    <div data-toggle="modal" data-target="#modal_aside_right" class="btn-md">
                        <span class="navbar-toggler-icon"></span>
                    </div>
                </div>
                <figure class="mb-0 mx-auto">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset($settings['site_logo']) }}" class="img-fluid logo" aria-label="Go to kaptenforex" alt="kaptenforex Logo" >
                    </a>
                </figure>


                <div class="collapse navbar-collapse justify-content-between" id="main_nav99">
                    <ul class="navbar-nav ml-auto">
                        @foreach ($featuredCategories as $category)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('news', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach

                        @if (count($categories) > 0)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                                {{ __('frontend.More') }}
                            </a>
                            <ul class="dropdown-menu animate fade-up">
                                @foreach ($categories as $category)
                                <li>
                                    <a class="dropdown-item icon-arrow" href="{{ route('news', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">
                                {{ __('frontend.About Us') }}
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">
                                {{ __('frontend.contact') }}
                            </a></li>
                    </ul>

                    <!-- Search bar -->
                    <ul class="navbar-nav">
                        <li class="nav-item search hidden-xs hidden-sm">
                            <a class="nav-link" href="#">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>

                    <!-- Search content bar -->
                    <div class="top-search navigation-shadow">
                        <div class="container">
                            <div class="input-group">
                                <form action="{{ route('news') }}" method="GET">
                                    <div class="row no-gutters mt-3">
                                        <div class="col">
                                            <input class="form-control border-secondary border-right-0 rounded-0" type="search" value="" placeholder="Search " id="example-search-input4" name="search">
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-outline-secondary border-left-0 rounded-0 rounded-right">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Search content bar -->
                </div> <!-- navbar-collapse -->
            </div> <!-- container -->
        </nav>
    </div>
    <!-- End Navbar menu -->

    <!-- Navbar sidebar menu -->
    <div id="modal_aside_right" class="modal fixed-left fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-aside" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="widget__form-search-bar">
                        <form action="{{ route('news') }}" method="GET">
                            <div class="row no-gutters">
                                <div class="col">
                                    <input class="form-control border-secondary border-right-0 rounded-0" placeholder="Search" type="search" name="search">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-secondary border-left-0 rounded-0 rounded-right">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <nav class="list-group list-group-flush">
                        <select id="nav-side-site-language">
                            @foreach ($languages as $language)
                            <option value="{{ $language->lang }}" {{ getLangauge() === $language->lang ? 'selected' : '' }}>
                                {{ $language->name }}
                            </option>
                            @endforeach
                        </select>
                        <ul class="navbar-nav">
                            @foreach ($featuredCategories as $category)
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('news', ['category' => $category->slug]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                            @endforeach

                            @if ($categories->isNotEmpty())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-dark" href="#" data-toggle="dropdown">
                                    More
                                </a>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    @foreach ($categories as $category)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('news', ['category' => $category->slug]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('about') }}">
                                    {{ __('frontend.About Us') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link text-dark" href="{{ route('contact') }}">
                                    {{ __('frontend.contact') }}
                                </a>
                            </li>

                            <li class="nav-item">
                                @guest
                                <a class="nav-link text-dark" href="{{ route('login') }}">
                                    {{ __('frontend.Login') }}
                                </a>
                                <a class="nav-link text-dark" href="{{ route('register') }}">
                                    {{ __('frontend.Register') }}
                                </a>
                                @else
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a class="nav-link text-dark" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('frontend.Logout') }}
                                    </a>
                                </form>
                                @endguest
                            </li>



                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- End Navbar sidebar menu -->
</header>
