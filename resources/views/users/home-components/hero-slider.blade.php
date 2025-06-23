<section>

    <style>
        /* Default (hide ads) */
        .ads-left,
        .ads-right {
            display: none;
        }

        /* Display ads only on desktop */
        @media (min-width: 1441px) {

            .ads-left,
            .ads-right {
                display: block;
                position: fixed;
                top: 100px;
                /* Adjust based on your layout */
                width: 160px;
                /* Adjust based on your ad size */
                height: 550px;
                /* Adjust based on your ad size */
                background-color: #f1f1f1;
                /* Just for visual reference */
                z-index: 1000;
                /* Ensure ads are on top */
            }

            .ads-left {
                left: 0;
            }

            .ads-right {
                right: 0;
            }
        }
    </style>
    <!-- Popular news  header-->
    <div class="popular__news-header">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-8">
                    <div class="card__post-carousel">
                        @foreach ($heroSlider as $slider)
                        @if ($loop->index <= 4)
                            <div class="item">
                                <!-- Post Article -->
                                <div class="card__post">
                                    <div class="card__post__body">
                                        <a href="{{ route('news-details', $slider->slug) }}">
                                            <img src="{{ asset($slider->image) }}" class="img-fluid" alt="">
                                        </a>
                                        <div class="card__post__content bg__post-cover">
                                            <div class="card__post__category">
                                                {{ $slider->category->name }}
                                            </div>
                                            <div class="card__post__title">
                                                <h2>
                                                    <a href="{{ route('news-details', $slider->slug) }}">
                                                        {!! truncate($slider->title, 100) !!}
                                                    </a>
                                                </h2>
                                            </div>
                                            <div class="card__post__author-info">
                                                <ul class="list-inline">
                                                    <li class="list-inline-item">
                                                        <a href="javascript:;">
                                                            {{ __('frontend.by') }} {{ $slider->auther->name }}
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <span>
                                                            {{ date('M d, Y', strtotime($slider->created_at)) }}
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="popular__news-right">
                        <!-- Post Article -->
                        @foreach ($heroSlider as $slider)
                        @if ($loop->index > 4 && $loop->index <= 6)
                        <div class="card__post ">
                            <div class="card__post__body card__post__transition">
                                <a href="{{ route('news-details', $slider->slug) }}">
                                    <img src="{{ asset($slider->image) }}" class="img-fluid" alt="">
                                </a>
                                <div class="card__post__content bg__post-cover">
                                    <div class="card__post__category">
                                        {{ $slider->category->name }}
                                    </div>
                                    <div class="card__post__title">
                                        <h5>
                                            <a href="{{ route('news-details', $slider->slug) }}">
                                                {!! truncate($slider->title, 100) !!}
                                            </a>
                                        </h5>
                                    </div>
                                    <div class="card__post__author-info">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="javascript:;">
                                                    by {{ $slider->auther->name }}
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    {{ date('M d, Y', strtotime($slider->created_at)) }}
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if ($ad->ads_banner_left_status == 1)
        <div class="ads-left">
            <a href="{{ $ad->ads_banner_left_url }}">
                <img src="{{ asset($ad->ads_banner_left) }}">
            </a>
        </div>
        @endif
        @if ($ad->ads_banner_right_status == 1)
        <div class="ads-right">
            <a href="{{ $ad->ads_banner_right_url }}">
                <img src="{{ asset($ad->ads_banner_right) }}">
            </a>
        </div>
        @endif
    </div>
</section>
