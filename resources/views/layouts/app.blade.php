<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="/storage/{{ nova_get_setting('logo') }}" />
    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.16"></script>
    <style>
        .fixed-position {
            position: fixed;
            right: 0.25rem;
            /* equivalent to right-1 */
            bottom: 1.25rem;
            /* equivalent to bottom-5 */
            z-index: 9999;
        }

        @media (min-width: 768px) {

            /* for medium screens and up */
            .fixed-position {
                right: 1.25rem;
                /* equivalent to right-5 */
            }
        }

        .bouncing-pointer {
            cursor: pointer;
            width: 75px;
            animation: bounce 1s infinite;
            /* Animation effect for bounce */
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-25%);
            }
        }

        .custom-box {
            background-color: #f3f4f6;
            /* bg-gray-100 */
            border: 1px solid #e5e7eb;
            /* typical border color for gray borders */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            /* shadow */
            width: 100%;
            max-width: 100%;
            height: 80vh;
            position: fixed;
            bottom: 0;
            right: 0;
            padding: 1rem;
            /* p-4 */
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            /* space-y-4 */
        }

        @media (min-width: 768px) {

            /* Medium screens and up */
            .custom-box {
                width: 450px;
                /* md:w-[450px] */
                height: 50vh;
                /* md:h-[50vh] */
            }
        }
        .green-button {
            margin-bottom: 0.5rem; /* mb-2 */
            background-color: #16a34a; /* bg-green-600 */
            color: #ffffff; /* text-white */
            padding: 0.5rem; /* p-2 */
            }
            .blue-button {
            margin-bottom: 0.5rem; /* mb-2 */
            background-color: #1e3a8a; /* bg-blue-900 */
            color: #ffffff; /* text-white */
            padding: 0.5rem; /* p-2 */
            }

            .green-border-box {
            color: #16a34a; /* text-green-600 */
            border: 1px solid #16a34a; /* border and border-green-600 */
            padding: 0.5rem; /* p-2 */
            display: flex; /* flex */
            align-items: center; /* items-center */
            }

            .green-text-box {
            width: 20px; /* w-[20px] */
            color: #16a34a; /* text-green-600 */
            }
            .flex-wrap-container {
            display: flex; /* flex */
            flex-wrap: wrap; /* flex-wrap */
            gap: 0.5rem; /* gap-2 */
            }
            /* Pure CSS dropdown toggle with click */
        /* Pure CSS dropdown toggle with click */
        .pure-css-click-dropdown {
            position: relative;
        }

        .pure-css-click-dropdown input[type="checkbox"] {
            display: none;
        }

        .pure-css-click-dropdown input[type="checkbox"]:checked ~ .dropdown-menu {
            display: block;
        }

        .pure-css-click-dropdown .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            z-index: 1000;
            min-width: 150px;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 15px;
            display: block;
            color: #333;
            text-decoration: none;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #0056b3;
        }

        .pure-css-click-dropdown label {
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .pure-css-click-dropdown .dropdown-icon {
            margin-left: 8px;
            transition: transform 0.3s ease;
        }

        .pure-css-click-dropdown input[type="checkbox"]:checked + label .dropdown-icon {
            transform: rotate(180deg);
        }
    </style>
</head>

<body>

    @include('sweetalert::alert')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#about-us') }}">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#our-services') }}">Services</a>
                            </li>
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/">{{ __('Home') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#about-us') }}">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/#our-services') }}">Services</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" target="_blank" href="/dental-record/{{ auth()->id() }}">{{ __('Dental Record') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" id="load-treatment-history">Treatment History</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/x-ray/{{ auth()->id() }}">X-ray</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/home">{{ __('Appointment') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/faq">{{ __('FAQ') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                            <div class="pure-css-click-dropdown">
                                <!-- Hidden checkbox for toggling -->
                                <input type="checkbox" id="dropdownToggle" />
                                <label for="dropdownToggle" class="nav-link">
                                    {{ Auth::user()->name }}
                                    <span class="dropdown-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                    </span>
                                </label>

                                <!-- Dropdown menu -->
                                <div class="dropdown-menu dropdown-menu-end">
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin: 0;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Modal for Treatment History -->
        <div class="modal fade" id="treatmentHistoryModal" tabindex="-1" role="dialog" aria-labelledby="treatmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="treatmentHistoryModalLabel">Treatment History</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="treatment-history-content">
                        <!-- The Treatment History content will load here -->
                        <div class="text-center">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- 2. Link VCalendar Javascript (Plugin automatically installed) -->
        <script src='https://unpkg.com/v-calendar'></script>
        <main>
            @yield('content')
        </main>

    </div>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                const treatmentHistoryButton = document.getElementById('load-treatment-history');
                const treatmentHistoryModal = new bootstrap.Modal(document.getElementById('treatmentHistoryModal'));

                treatmentHistoryButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    const url = '/treatment-history/{{ auth()->id() }}';

                    // Show the modal
                    treatmentHistoryModal.show();

                    // Clear previous content and show the loading spinner
                    const contentDiv = document.getElementById('treatment-history-content');
                    contentDiv.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>';

                    // Make AJAX request
                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML = html; // Load the fetched content into the modal
                        })
                        .catch(error => {
                            contentDiv.innerHTML = '<div class="alert alert-danger">An error occurred while loading the treatment history.</div>';
                            console.error('Error fetching treatment history:', error);
                        });
                });
            });
        </script>
</body>

</html>
