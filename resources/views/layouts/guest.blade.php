@props(['maxWidth' => 'sm:max-w-md'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Favicon -->
        @php
            $faviconPath = public_path('Pictures/LOGO/LOGO-eturismo.png');
            $faviconVersion = file_exists($faviconPath) ? filemtime($faviconPath) : '1';
            $faviconUrl = asset('Pictures/LOGO/LOGO-eturismo.png') . '?v=' . $faviconVersion;
        @endphp
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $faviconUrl }}">
        <link rel="shortcut icon" href="{{ $faviconUrl }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background-color: #061810 !important;
            }

            #auth-card {
                position: relative;
                /* Gradient Glassmorphism Background */
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.02) 100%) !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                border-top-color: rgba(255, 255, 255, 0.3) !important;
                border-left-color: rgba(255, 255, 255, 0.3) !important;
                border-radius: 1.25rem !important; /* 20px corner radius */
                box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                transition: border-color 0.3s ease, box-shadow 0.3s ease, background 0.3s ease, transform 0.1s ease-out !important;
            }

            #auth-card:hover,
            #auth-card:focus-within {
                border-color: rgba(255, 255, 255, 0.6) !important;
                /* Seamless white glow on hover */
                box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5), 0 0 30px rgba(255, 255, 255, 0.15) !important;
            }

            /* Spotlight overlay */
            .spotlight-overlay {
                position: absolute;
                inset: 0;
                pointer-events: none;
                z-index: 0;
                opacity: 0;
                transition: opacity 0.25s ease-out;
                background: radial-gradient(
                    300px circle at var(--mouse-x, 0px) var(--mouse-y, 0px),
                    rgba(255, 255, 255, 0.12) 0%,
                    rgba(255, 255, 255, 0.03) 40%,
                    transparent 100%
                );
                border-radius: inherit;
            }

            #auth-card:hover .spotlight-overlay {
                opacity: 1;
            }

            /* Ensure slot content sits above the spotlight overlay */
            #auth-card > *:not(.spotlight-overlay) {
                position: relative;
                z-index: 1;
            }

            /* ── Global Inputs inside auth card ── */
            #auth-card input[type="text"],
            #auth-card input[type="email"],
            #auth-card input[type="password"],
            #auth-card input[type="date"],
            #auth-card select,
            #auth-card textarea {
                background-color: rgba(255, 255, 255, 0.9) !important;
                color: #1e293b !important;
                border: 1px solid rgba(255, 255, 255, 0.15) !important;
                border-radius: 0.5rem !important; /* rounded-lg */
                padding: 0.625rem 0.875rem !important;
                font-size: 0.875rem !important;
                font-weight: 500 !important;
                box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.06) !important;
                transition: border-color 0.25s ease-out, box-shadow 0.25s ease-out, background-color 0.25s ease-out !important;
            }

            #auth-card input[type="text"]:focus,
            #auth-card input[type="email"]:focus,
            #auth-card input[type="password"]:focus,
            #auth-card input[type="date"]:focus,
            #auth-card select:focus,
            #auth-card textarea:focus {
                background-color: #ffffff !important;
                border-color: #ffffff !important;
                box-shadow: 0 0 10px rgba(255, 255, 255, 0.6), inset 0 2px 4px rgba(0, 0, 0, 0.06) !important;
            }

            /* ── Buttons styling ── */
            #auth-card button[type="submit"],
            #auth-card .btn-primary,
            #auth-card .otp-button,
            #auth-card x-primary-button,
            #auth-card #submit-btn {
                background-color: #10b981 !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                padding: 0.625rem 1.25rem !important;
                border-radius: 0.5rem !important;
                border: none !important;
                cursor: pointer !important;
                box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2), 0 2px 4px -1px rgba(16, 185, 129, 0.1) !important;
                transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.2s ease-out, background-color 0.2s ease-out !important;
            }

            #auth-card button[type="submit"]:hover:not(:disabled),
            #auth-card .btn-primary:hover:not(:disabled),
            #auth-card .otp-button:hover:not(:disabled),
            #auth-card #submit-btn:hover:not(:disabled) {
                background-color: #059669 !important;
                transform: scale(1.03) !important;
                box-shadow: 0 0 15px rgba(16, 185, 129, 0.5), 0 10px 15px -3px rgba(16, 185, 129, 0.3) !important;
            }

            #auth-card button[type="submit"]:active:not(:disabled),
            #auth-card .btn-primary:active:not(:disabled),
            #auth-card .otp-button:active:not(:disabled),
            #auth-card #submit-btn:active:not(:disabled) {
                transform: scale(0.97) !important;
            }

            #auth-card button[type="submit"]:disabled,
            #auth-card .btn-primary:disabled,
            #auth-card .otp-button:disabled,
            #auth-card #submit-btn:disabled {
                background-color: rgba(255, 255, 255, 0.1) !important;
                color: rgba(255, 255, 255, 0.3) !important;
                cursor: not-allowed !important;
                box-shadow: none !important;
                transform: none !important;
            }

            /* ── Link styling ── */
            #auth-card a:not(.group):not(.btn-prev-step) {
                color: #34d399 !important;
                font-weight: 600 !important;
                text-decoration: none !important;
                border-bottom: 1px solid transparent !important;
                transition: color 0.2s ease-out, border-color 0.2s ease-out !important;
            }

            #auth-card a:not(.group):not(.btn-prev-step):hover {
                color: #a7f3d0 !important;
                border-color: #a7f3d0 !important;
            }

            /* Respect prefers-reduced-motion */
            @media (prefers-reduced-motion: reduce) {
                #auth-card {
                    transition: none !important;
                }
                #auth-card:hover,
                #auth-card:focus-within {
                    border-color: rgba(255, 255, 255, 0.25) !important;
                    box-shadow: 0 0 30px rgba(255, 255, 255, 0.06), 0 20px 40px rgba(0, 0, 0, 0.6) !important;
                }
                .spotlight-overlay {
                    display: none !important;
                }
                #auth-card input,
                #auth-card button,
                #auth-card a {
                    transition: none !important;
                    transform: none !important;
                }
                #auth-card button:hover:not(:disabled) {
                    transform: none !important;
                }
            }

            /* ── Polished Password Toggle Button ── */
            .password-toggle-btn {
                position: absolute;
                right: 12px;
                top: 0;
                bottom: 0;
                margin-top: auto !important;
                margin-bottom: auto !important;
                width: 32px;
                height: 32px;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 50%;
                color: #94a3b8 !important; /* muted gray */
                background: transparent !important;
                border: none !important;
                cursor: pointer !important;
                outline: none !important;
                padding: 0 !important;
                transition: color 0.2s ease, transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1), background-color 0.2s ease, box-shadow 0.2s ease !important;
                box-shadow: none !important;
                z-index: 10 !important;
                transform: scale(1);
            }

            .password-toggle-btn:hover {
                color: #10b981 !important; /* brand green */
                transform: scale(1.1) !important;
                background-color: rgba(16, 185, 129, 0.1) !important; /* soft green hit area */
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.2) !important;
            }

            .password-toggle-btn:active {
                transform: scale(0.9) !important;
            }

            /* Focus visible ring */
            .password-toggle-btn:focus-visible {
                box-shadow: 0 0 0 2px #ffffff, 0 0 0 4px #10b981 !important;
                color: #10b981 !important;
            }

            /* Circular hit area ripple */
            .password-toggle-btn::after {
                content: '';
                position: absolute;
                inset: 0;
                border-radius: 50%;
                background: rgba(16, 185, 129, 0.25);
                transform: scale(0);
                opacity: 0;
                pointer-events: none;
            }

            .password-toggle-btn.ripple-active::after {
                animation: toggle-ripple 0.35s ease-out forwards;
            }

            @keyframes toggle-ripple {
                0% {
                    transform: scale(0.4);
                    opacity: 1;
                }
                100% {
                    transform: scale(1.2);
                    opacity: 0;
                }
            }

            /* ── SVG eye-icon morph states ── */
            .eye-icon-svg {
                display: block !important;
                margin: 0 !important;
                transition: transform 0.25s ease-out;
            }

            .eye-slash {
                stroke-dasharray: 23;
                stroke-dashoffset: 23;
                transition: stroke-dashoffset 0.25s ease-in-out !important;
            }

            .eye-pupil {
                transition: transform 0.25s ease-in-out, opacity 0.25s ease-in-out !important;
                transform-origin: center;
            }

            .eye-lid {
                transition: opacity 0.25s ease-in-out !important;
            }

            /* Hidden state: slash is drawn, pupil fades slightly */
            .password-toggle-btn.toggled-hidden .eye-slash {
                stroke-dashoffset: 0 !important;
            }

            .password-toggle-btn.toggled-hidden .eye-pupil {
                opacity: 0.3 !important;
                transform: scale(0.8) !important;
            }

            /* ── Character morph overlay animations ── */
            .password-reveal-overlay {
                font-family: inherit;
                pointer-events: none;
                white-space: nowrap;
            }

            .char-morph {
                display: inline-block;
                transform-style: preserve-3d;
                backface-visibility: hidden;
                transform-origin: center;
                opacity: 1;
            }

            .morph-to-char {
                animation: morph-char-anim 0.2s ease-out forwards;
            }

            .morph-to-mask {
                animation: morph-char-anim 0.2s ease-out forwards;
            }

            @keyframes morph-char-anim {
                0% {
                    transform: rotateX(0deg);
                }
                50% {
                    transform: rotateX(90deg);
                }
                100% {
                    transform: rotateX(0deg);
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased relative">
        <!-- Background Video -->
        <video autoplay loop muted playsinline class="fixed inset-0 w-full h-full object-cover -z-10">
            <source src="{{ asset('Videos/bgv1.webm') }}" type="video/webm">
        </video>
        
        <!-- Dark Overlay -->
        <div class="fixed inset-0 bg-black/40 -z-10"></div>

        <div class="min-h-screen flex flex-col justify-center items-center py-6 px-4 sm:px-6 relative z-0">
            <div class="pointer-events-none select-none mb-3">
                <x-application-logo class="w-16 h-16 sm:w-20 sm:h-20 drop-shadow-md cursor-default" style="filter: brightness(0) invert(1);" />
            </div>

            <div id="auth-card" class="{{ $maxWidth }} w-full max-w-md mx-auto px-5 py-5 sm:px-7 sm:py-6 overflow-hidden">
                <div class="spotlight-overlay"></div>
                {{ $slot }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const card = document.getElementById('auth-card');
                if (!card) return;

                const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                if (prefersReducedMotion) return;

                let ticking = false;

                card.addEventListener('mousemove', function (e) {
                    if (!ticking) {
                        window.requestAnimationFrame(function () {
                            const rect = card.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            
                            // Spotlight coordinates
                            card.style.setProperty('--mouse-x', `${x}px`);
                            card.style.setProperty('--mouse-y', `${y}px`);
                            
                            // 3D Tilt calculation
                            const centerX = rect.width / 2;
                            const centerY = rect.height / 2;
                            const rotateX = ((y - centerY) / centerY) * -4; // Max 4 degrees
                            const rotateY = ((x - centerX) / centerX) * 4;  // Max 4 degrees
                            
                            // Combine perspective, levitation (translateY), tilt, and scale
                            card.style.transform = `perspective(1000px) translateY(-8px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
                            
                            ticking = false;
                        });
                        ticking = true;
                    }
                });

                card.addEventListener('mouseleave', function () {
                    window.requestAnimationFrame(function () {
                        card.style.transform = `perspective(1000px) translateY(0px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)`;
                        card.style.transition = `transform 0.5s ease-out`;
                    });
                });
                
                card.addEventListener('mouseenter', function () {
                    card.style.transition = `transform 0.1s ease-out`;
                });
            });

            // ── Polished Password Toggle revealing stagger and icon morph ──
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                if (!input) return;

                const isPassword = input.type === 'password';
                const newVal = isPassword ? 'text' : 'password';

                // Accessibility updates
                btn.setAttribute('aria-pressed', isPassword ? 'true' : 'false');
                btn.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');

                // Tactile ripple feedback
                btn.classList.add('ripple-active');
                btn.addEventListener('animationend', function () {
                    btn.classList.remove('ripple-active');
                }, { once: true });

                // Toggle icon visual state class
                if (newVal === 'password') {
                    btn.classList.add('toggled-hidden');
                } else {
                    btn.classList.remove('toggled-hidden');
                }

                const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                const val = input.value;

                if (reducedMotion || !val) {
                    input.type = newVal;
                    return;
                }

                // Staggered reveal animation using overlay
                const overlay = document.createElement('div');
                overlay.className = 'password-reveal-overlay';
                
                const style = window.getComputedStyle(input);
                
                Object.assign(overlay.style, {
                    position: 'absolute',
                    left: `${input.offsetLeft + parseFloat(style.paddingLeft)}px`,
                    top: `${input.offsetTop + parseFloat(style.paddingTop)}px`,
                    height: `${input.clientHeight - parseFloat(style.paddingTop) - parseFloat(style.paddingBottom)}px`,
                    width: `${input.clientWidth - parseFloat(style.paddingLeft) - parseFloat(style.paddingRight)}px`,
                    display: 'flex',
                    alignItems: 'center',
                    fontFamily: style.fontFamily,
                    fontSize: style.fontSize,
                    fontWeight: style.fontWeight,
                    letterSpacing: style.letterSpacing,
                    lineHeight: style.lineHeight,
                    pointerEvents: 'none',
                    color: style.color, /* match input text color dynamically */
                    overflow: 'hidden',
                    zIndex: '1'
                });

                const chars = val.split('');
                chars.forEach((char, idx) => {
                    const span = document.createElement('span');
                    span.className = 'char-morph';
                    span.textContent = isPassword ? '•' : char;
                    span.style.animationDelay = `${idx * 25}ms`;
                    span.style.display = 'inline-block';
                    span.classList.add(isPassword ? 'morph-to-char' : 'morph-to-mask');

                    setTimeout(() => {
                        span.textContent = isPassword ? char : '•';
                    }, (idx * 25) + 100);

                    overlay.appendChild(span);
                });

                const parent = input.parentElement;
                parent.appendChild(overlay);
                input.style.color = 'transparent';
                input.type = newVal;

                const totalDuration = (chars.length * 25) + 200;
                setTimeout(() => {
                    overlay.remove();
                    input.style.color = '';
                }, totalDuration);
            }
        </script>
        <!-- CSRF Token Keep-Alive -->
        <script>
            setInterval(function () {
                fetch('{{ route("home") }}', { method: 'HEAD' }).catch(function () {});
            }, 600000);
        </script>
    </body>
</html>
