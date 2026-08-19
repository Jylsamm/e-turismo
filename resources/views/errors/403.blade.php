<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Unauthorized Action | E-Turismo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-3xl p-8 border border-gray-200 shadow-xl text-center space-y-6">
        
        {{-- Shield / Lock Icon Badge --}}
        <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 border border-amber-200 flex items-center justify-center mx-auto shadow-sm">
            <i class="ti ti-shield-lock text-4xl"></i>
        </div>

        <div>
            <span class="inline-block px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wider bg-amber-100 text-amber-900 border border-amber-200 mb-2">
                403 — Unauthorized Action
            </span>
            <h1 class="text-2xl font-bold text-gray-900">Access Restricted</h1>
            <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                {{ $exception->getMessage() ?: 'You do not have administrative permission to perform this action or manage this destination under the 1 Staff = 1 Spot policy.' }}
            </p>
        </div>

        <div class="pt-2 flex flex-col sm:flex-row gap-3 justify-center">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('dashboard') }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-semibold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="ti ti-dashboard"></i> Back to Dashboard
                    </a>
                @elseif(auth()->user()->isStaff() && auth()->user()->assigned_destination_id)
                    <a href="{{ route('spots.dashboard', auth()->user()->assigned_destination_id) }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-semibold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="ti ti-chart-bar"></i> Go to Assigned Spot
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" 
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-semibold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                        <i class="ti ti-home"></i> Back to Dashboard
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" 
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-green-700 hover:bg-green-800 text-white font-semibold text-sm shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                    <i class="ti ti-login"></i> Log In
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
