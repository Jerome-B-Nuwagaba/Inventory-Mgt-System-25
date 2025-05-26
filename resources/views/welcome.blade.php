<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Motor Planet Inventory System</title>

        <!-- Fonts -->
        <link rel="icon" href="/images/Mercedes.png" type="image/x-icon">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
        
        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                body {
                    font-family: 'Inter', sans-serif;
                }
                .hero {
                    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.6)),
                    url('/images/Mercedes.png') center/cover no-repeat;
                }
                .icon-box {
                    width: 64px;
                    height: 64px;
                }
            </style>
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>
        
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="w-full">
                <section class="hero text-center text-white py-32 px-6">
                    <h2 class="text-5xl font-extrabold mb-6">Smart Motor Inventory at Your Fingertips</h2>
                    <p class="text-lg mb-8 max-w-2xl mx-auto">Track your vehicle stock, monitor performance, and manage your sales from a single intelligent platform.</p>
                    <div class="space-x-4">
                        <a href="{{ route('register') }}" class="bg-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-blue-700 shadow-lg">Get Started</a>
                        <a href="#" class="border border-white px-8 py-4 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition">Learn More</a>
                    </div>
                </section>

                <section class="py-20 bg-white dark:bg-gray-800">
                    <div class="container mx-auto text-center mb-12">
                        <h3 class="text-3xl font-bold mb-4">Why Choose Motor Planet?</h3>
                        <p class="text-gray-600 dark:text-gray-300 max-w-xl mx-auto">Empowering dealerships and warehouses with seamless motor inventory control.</p>
                    </div>
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 px-6">
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl p-6 text-center hover:shadow-lg transition">                            
                        <h4 class="text-xl font-semibold mb-2">Vehicle Tracking</h4>
                            <p>Real-time updates on inventory status, availability, and movement.</p>
                        </div>

                        
                            <h4 class="text-xl font-semibold mb-2">Stock Insights</h4>
                            <p>Visual dashboards and reports to help you make informed decisions.</p>
                        </div>

                        <div class="bg-gray-100 dark:bg-gray-700 rounded-2xl p-6 text-center hover:shadow-lg transition">                            
                            <h4 class="text-xl font-semibold mb-2">Seamless Transfers</h4>
                            <p>Move motors between branches with a single click and track instantly.</p>
                        </div>
                    </div>
                </section>

                <section class="bg-blue-600 dark:bg-blue-700 py-16 text-white text-center">
                    <h3 class="text-3xl font-bold mb-4">Join 1,000+ dealers using Motor Planet</h3>
                    <p class="mb-6">Manage smarter, scale faster. Take control of your motor inventory today.</p>
                    <a href="{{ route('register') }}" class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition">Register Now</a>
                </section>
            </main>
        </div>

        <footer class="w-full bg-gray-900 text-gray-300 py-12">
            <div class="container mx-auto grid md:grid-cols-4 gap-8 px-6">
                <div>
                    <h4 class="text-white font-semibold mb-4">Motor Planet</h4>
                    <p class="text-sm">Your partner in intelligent motor inventory systems.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400">Inventory</a></li>
                        <li><a href="#" class="hover:text-blue-400">Reports</a></li>
                        <li><a href="#" class="hover:text-blue-400">Support</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-blue-400">About Us</a></li>
                        <li><a href="#" class="hover:text-blue-400">Careers</a></li>
                        <li><a href="#" class="hover:text-blue-400">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Connect</h4>
                    <div class="flex space-x-4 text-sm">
                        <a href="#" class="hover:text-blue-400">Facebook</a>
                        <a href="#" class="hover:text-blue-400">Twitter</a>
                        <a href="#" class="hover:text-blue-400">LinkedIn</a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-8 text-sm border-t border-gray-700 pt-6">
                &copy; {{ date('Y') }} Motor Planet. All rights reserved.
            </div>
        </footer>
    </body>
</html>