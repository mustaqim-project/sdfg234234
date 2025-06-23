<!DOCTYPE html>

<html lang="id-ID" class="scroll-smooth scroll-pt-[88px]" id="anchor">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        @hasSection('title')
            @yield('title')
        @else
            {{ $settings['site_seo_title'] }}
        @endif
    </title>




    <link rel="icon" href="{{ asset($settings['site_favicon']) }}" type="image/png">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,700,700i&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,900">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,500,500i,600,600i,700,700i,800|Playfair+Display:400,400i,700,700i,900&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.12/css/lightgallery.min.css">


    <meta name="description" content="@yield('meta_description', $settings['site_seo_description'] ?? '')" />
    <meta name="keywords" content="@yield('meta_keyword', $settings['site_seo_keywords'] ?? '')" itemprop="keywords" />



    <meta name="og:title"
        content="@hasSection('meta_og_title')
@yield('meta_og_title')
@else
{{ $settings['site_name'] }}
@endif" />
    <meta name="og:description"
        content="@hasSection('meta_og_description')
@yield('meta_og_description')
@else
{{ $settings['site_seo_description'] }}
@endif" />
    <meta name="og:image"
        content="@hasSection('meta_og_image')
@yield('meta_og_image')
@else
{{ asset($settings['site_logo']) }}
@endif" />

    <meta name="twitter:title"
        content="@hasSection('meta_tw_title')
@yield('meta_tw_title')
@else
{{ $settings['site_name'] }}
@endif" />
    <meta name="twitter:description"
        content="@hasSection('meta_tw_description')
@yield('meta_tw_description')
@else
{{ $settings['site_seo_description'] }}
@endif" />
    <meta name="twitter:image"
        content="@hasSection('meta_tw_image')
@yield('meta_tw_image')
@else
{{ asset($settings['site_logo']) }}
@endif" />



    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="yandex-verification" content="38a12012982f111e" />
    <meta name="msvalidate.01" content="1EB24BC8F76A22915E1CC801D9CA1F92" />
<meta name="google-adsense-account" content="ca-pub-5016031411419450">
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5016031411419450"
     crossorigin="anonymous"></script>
     



    <style>
        :root {
            --colorPrimary: {{ $settings['site_color'] }};
        }

        .lazy {
            opacity: 0;
            transition: opacity 0.3s;
        }

        .lazy.loaded {
            opacity: 1;
        }

        html.scroll-smooth {
            scroll-behavior: smooth;
        }

        html.scroll-pt-\[88px\] {
            scroll-padding-top: 88px;
        }
    </style>

</head>

<body>

    <!-- Global Variables -->
    @php
        $socialLinks = \App\Models\SocialLink::where('status', 1)->get();
        $footerInfo = \App\Models\FooterInfo::where('language', getLangauge())->first();
        $footerGridOne = \App\Models\FooterGridOne::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridTwo = \App\Models\FooterGridTwo::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridThree = \App\Models\FooterGridThree::where(['status' => 1, 'language' => getLangauge()])->get();
        $footerGridOneTitle = \App\Models\FooterTitle::where([
            'key' => 'grid_one_title',
            'language' => getLangauge(),
        ])->first();
        $footerGridTwoTitle = \App\Models\FooterTitle::where([
            'key' => 'grid_two_title',
            'language' => getLangauge(),
        ])->first();
        $footerGridThreeTitle = \App\Models\FooterTitle::where([
            'key' => 'grid_three_title',
            'language' => getLangauge(),
        ])->first();
    @endphp

    <!-- Header news -->
    @include('frontend.layouts.header')
    <!-- End Header news -->

    @yield('content')

    <!-- Footer Section -->
    @include('frontend.layouts.footer')
    <!-- End Footer Section -->


    <a href="javascript:" id="return-to-top" aria-label="Return to top of the page"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>
    @include('sweetalert::alert')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const lazyImages = document.querySelectorAll('img.lazy');

            function handleLazyLoad() {
                lazyImages.forEach(img => {
                    if (img.getBoundingClientRect().top < window.innerHeight && img.getBoundingClientRect()
                        .bottom >= 0) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                    }
                });
            }

            window.addEventListener('scroll', handleLazyLoad);
            window.addEventListener('resize', handleLazyLoad);
            handleLazyLoad(); // Initial check
        });


        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        // Add csrf token in ajax request
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            $('#site-language').on('change', function() {
                let languageCode = $(this).val();
                $('html').attr('lang', languageCode);
                $.ajax({
                    method: 'GET',
                    url: "{{ route('language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(data) {
                        console.error(data);
                    }
                });
            });



            $('#nav-side-site-language').on('change', function() {
                let languageCode = $(this).val();
                $('html').attr('lang', languageCode);
                $.ajax({
                    method: 'GET',
                    url: "{{ route('language') }}",
                    data: {
                        language_code: languageCode
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            window.location.href = "{{ url('/') }}";
                        }
                    },
                    error: function(data) {
                        console.error(data);
                    }
                });
            });

            /** Subscribe Newsletter**/
            $('.newsletter-form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    method: 'POST',
                    url: "{{ route('subscribe-newsletter') }}",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.newsletter-button').text('loading...');
                        $('.newsletter-button').attr('disabled', true);
                    },
                    success: function(data) {
                        if (data.status === 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            })
                            $('.newsletter-form')[0].reset();
                            $('.newsletter-button').text('sign up');

                            $('.newsletter-button').attr('disabled', false);
                        }
                    },
                    error: function(data) {
                        $('.newsletter-button').text('sign up');
                        $('.newsletter-button').attr('disabled', false);

                        if (data.status === 422) {
                            let errors = data.responseJSON.errors;
                            $.each(errors, function(index, value) {
                                Toast.fire({
                                    icon: 'error',
                                    title: value[0]
                                })
                            })
                        }
                    }
                })
            })
        })
    </script>



    @stack('content')

</body>

</html>
