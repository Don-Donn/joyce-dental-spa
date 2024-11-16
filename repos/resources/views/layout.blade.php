<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full font-sans antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1280">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \Laravel\Nova\Nova::name() }}</title>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/main.min.css" rel="stylesheet" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('app.css', 'vendor/nova') }}">
    <!-- Tool Styles -->
    @foreach(\Laravel\Nova\Nova::availableStyles(request()) as $name => $path)
        @if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://']))
            <link rel="stylesheet" href="{!! $path !!}">
        @else
            <link rel="stylesheet" href="/nova-api/styles/{{ $name }}">
        @endif
    @endforeach

    <!-- Custom Meta Data -->
    @include('nova::partials.meta')

    <!-- Theme Styles -->
    @foreach(\Laravel\Nova\Nova::themeStyles() as $publicPath)
        <link rel="stylesheet" href="{{ $publicPath }}">
    @endforeach
</head>
<body class="min-w-site bg-40 text-90 font-medium min-h-full">
    @include('sweetalert::alert')
    <div id="nova">
        <div v-cloak class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="flex-none pt-header min-h-screen w-sidebar bg-grad-sidebar px-6">
                <a href="{{ \Laravel\Nova\Nova::path() }}">
                    <div class="absolute pin-t pin-l pin-r bg-logo flex items-center w-sidebar h-header px-6 text-white">
                       @include('nova::partials.logo')
                    </div>
                </a>

                @foreach (\Laravel\Nova\Nova::availableTools(request()) as $tool)
                    {!! $tool->renderNavigation() !!}
                @endforeach
            </div>

            <!-- Content -->
            <div class="content">
                <div class="flex items-center relative shadow h-header bg-white z-20 px-view">
                <a v-if="@json(\Laravel\Nova\Nova::name() !== null)" href="{{ \Illuminate\Support\Facades\Config::get('nova.url') }}" class="no-underline dim font-bold text-90 mr-6">
                    {{ \Laravel\Nova\Nova::name() }}
                </a>

                {{-- Container for Notification Icon and User --}}
                <div class="flex items-center ml-auto space-x-4">
                    {{-- Notification Icon with Dropdown --}}
                    <div class="relative">
                        <button id="notificationDropdownButton" class="relative flex items-center no-underline text-90 hover:bg-30 p-3 focus:outline-none" onclick="toggleDropdown('notificationDropdown')">
                            <!-- Replaced SVG with Font Awesome bell icon -->
                            <i class="fas fa-bell"></i>
                            <span id="notificationCount" class="absolute top-0 right-0 inline-block w-4 h-4 rounded-full bg-green-500 text-white text-center text-xs leading-tight">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        </button>

                        {{-- Notification Dropdown Panel --}}
                        <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 shadow-lg rounded-lg">
                            <div class="p-4 border-b">
                                <h3 class="text-sm font-semibold">Notifications</h3>
                            </div>
                            <div id="notificationList" class="max-h-64 overflow-y-auto">
                                @foreach(auth()->user()->unreadNotifications as $notification)
                                    <div class="p-3 border-b hover:bg-gray-100">
                                        <p class="text-xs text-gray-600">{{ $notification->created_at->diffForHumans() }}</p>
                                        <p class="text-sm font-medium">{{ $notification->data['message'] ?? 'New notification' }}</p>

                                        {{-- Display appointment details if available --}}
                                        @if(isset($notification->data['appointment_details']))
                                            <div class="mt-2 text-xs text-gray-700">
                                                <p><strong>Date:</strong> {{ $notification->data['appointment_details']['date'] ?? 'N/A' }}</p>
                                                <p><strong>Slot:</strong> {{ $notification->data['appointment_details']['slot'] ?? 'N/A' }}</p>
                                                @if(isset($notification->data['appointment_details']['remarks']))
                                                    <p><strong>Remarks:</strong> {{ $notification->data['appointment_details']['remarks'] }}</p>
                                                @endif
                                                <p><strong>Service:</strong> {{ $notification->data['appointment_details']['service'] ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                @if(auth()->user()->unreadNotifications->isEmpty())
                                    <div class="p-3 text-center text-gray-500">
                                        No new notifications
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- User Dropdown --}}
                    <dropdown class="h-9 flex items-center dropdown-right">
                        @include('nova::partials.user')
                    </dropdown>
                </div>
            </div>

            <script>
                function toggleDropdown(id) {
                    const dropdown = document.getElementById(id);
                    dropdown.classList.toggle('hidden');
                }

                // Close the dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    const notificationButton = document.getElementById('notificationDropdownButton');
                    const dropdown = document.getElementById('notificationDropdown');
                    if (!notificationButton.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });

                // Real-time notification listener
                document.addEventListener('DOMContentLoaded', function() {
                console.log('Echo initialized');
                const userId = {{ auth()->id() }};
                window.Echo.private(`notifications.${userId}`)
                    .listen('NewNotification', (e) => {
                        console.log('New notification received:', e);
                        const notificationList = document.getElementById('notificationList');
                        const newNotification = document.createElement('div');
                        newNotification.classList.add('p-3', 'border-b', 'hover:bg-gray-100');
                        newNotification.innerHTML = `
                            <p class="text-xs text-gray-600">${new Date().toLocaleString()}</p>
                            <p class="text-sm font-medium">${e.notification.message}</p>
                            ${e.notification.appointment_details ? `
                            <div class="mt-2 text-xs text-gray-700">
                                <p><strong>Date:</strong> ${e.notification.appointment_details.date}</p>
                                <p><strong>Slot:</strong> ${e.notification.appointment_details.slot}</p>
                                <p><strong>Remarks:</strong> ${e.notification.appointment_details.remarks ?? 'N/A'}</p>
                                <p><strong>Service:</strong> ${e.notification.appointment_details.service}</p>
                            </div>` : ''}
                        `;
                        notificationList.prepend(newNotification);
                        const notificationCount = document.getElementById('notificationCount');
                        notificationCount.textContent = parseInt(notificationCount.textContent) + 1;
                    });
            });
            </script>

            <div data-testid="content" class="px-view py-view mx-auto">
                @yield('content')

                @include('nova::partials.footer')
            </div>
        </div>
    </div>

    <script>
        window.config = @json(\Laravel\Nova\Nova::jsonVariables(request()));
    </script>

    <!-- Scripts -->
    <script src="{{ mix('manifest.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('vendor.js', 'vendor/nova') }}"></script>
    <script src="{{ mix('app.js', 'vendor/nova') }}"></script>

    <!-- Build Nova Instance -->
    <script>
        window.Nova = new CreateNova(config)
    </script>

    <!-- Tool Scripts -->
    @foreach (\Laravel\Nova\Nova::availableScripts(request()) as $name => $path)
        @if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://']))
            <script src="{!! $path !!}"></script>
        @else
            <script src="/nova-api/scripts/{{ $name }}"></script>
        @endif
    @endforeach

    <!-- Start Nova -->
    <script>
        Nova.liftOff()
    </script>
</body>
</html>