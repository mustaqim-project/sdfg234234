<section class="wrapper__section p-0">
    {{-- <style>
        /* General List Styling */
        .option-content {
            list-style-type: none;
            padding: 0;
        }

        .option-content li {
            margin-bottom: 10px; /* Adjust spacing between list items */
        }

        /* Link Styling */
        .option-content a {
            text-decoration: none;
            color: #000; /* Default link color */
            font-size: 15px; /* Text font size */
            display: block; /* Ensure link occupies the full width */
            padding: 10px;
        }

        .option-content a:hover {
            color: #007bff; /* Hover color for links */
        }

        /* Download Link Specific Styling */
        .download-link {
            background-color: white; /* Button background color white */
            color: #0052a3; /* Text color */
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            width: 100px;
            margin-bottom: 5px; /* Margin for spacing */
            padding: 7px; /* Padding inside the button */
            font-size: 15px; /* Font size for text */
            display: flex; /* Center icon and text vertically */
            align-items: center;
            justify-content: center;
        }

        .download-link:hover {
            background-color: #f1f1f1; /* Slightly lighter background on hover */
        }

        .download-icon {
            font-size: 24px; /* Icon font size */
            color: #0052a3; /* Icon color */
            margin-right: 5px; /* Space between icon and text */
        }

        /* Social Button Icon Styling */
        .btn-social > i {
            color: var(--colorPrimary) !important; /* Set the icon color */
        }

        /* Additional Responsive Design */
        @media (max-width: 768px) {
            .option-content a {
                font-size: 14px; /* Slightly smaller text size for mobile */
            }

            .download-link {
                width: 100%; /* Full width on smaller screens */
            }
        }
    </style> --}}

    <div class="wrapper__section__components">
        <!-- Footer -->
        <footer>
            <div class="wrapper__footer bg__footer-dark pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="widget__footer">
                                <figure class="image-logo">
                                    <img src="{{ asset(@$footerInfo->logo) }}" alt="kaptenforex Logo" class="img-fluid loaded" loading="lazy">
                                </figure>

                                <p>{{ @$footerInfo->description }}</p>

                                <div class="social__media mt-4">
                                    <ul class="list-inline">
                                        @foreach ($socialLinks as $link)
                                            <li class="list-inline-item">
                                                <a href="{{ $link->url }}" class="btn btn-social rounded text-white" aria-label="Go to kaptenforex Media Social" alt="kaptenforex Media Social">
                                                    <i class="{{ $link->icon }}"></i>
                                                </a>
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="widget__footer">
                                <div class="dropdown-footer">
                                    <h4 class="footer-title">
                                        {{ @$footerGridOneTitle->value }}
                                        <span class="fa fa-angle-down"></span>
                                    </h4>
                                </div>

                                <ul class="list-unstyled option-content is-hidden">
                                    @foreach ($footerGridOne as $gridOne)
                                        <li>
                                            <a href="{{ $gridOne->url }}">{{ $gridOne->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="widget__footer">
                                <div class="dropdown-footer">
                                    <h4 class="footer-title">
                                        {{ @$footerGridTwoTitle->value }}
                                        <span class="fa fa-angle-down"></span>
                                    </h4>
                                </div>
                                <ul class="list-unstyled option-content is-hidden">
                                    @foreach ($footerGridTwo as $gridTwo)
                                        <li>
                                            <a href="{{ $gridTwo->url }}">{{ $gridTwo->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="widget__footer">
                                <div class="dropdown-footer">
                                    <h4 class="footer-title">
                                        {{ @$footerGridThreeTitle->value }}
                                        <span class="fa fa-angle-down"></span>
                                    </h4>
                                </div>
                                <ul class="list-unstyled option-content is-hidden">
                                    @foreach ($footerGridThree as $gridThree)
                                        <li>
                                            <a href="{{ $gridThree->url }}">{{ $gridThree->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer bottom -->
            <div class="wrapper__footer-bottom bg__footer-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="border-top-1 bg__footer-bottom-section">
                                <p class="text-white text-center">
                                    {{ @$footerInfo->copyright }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</section>
