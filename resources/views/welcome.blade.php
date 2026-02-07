<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome | Inventory System</title></head>
    @vite('resources/css/app.css')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
     <style>
        html { scroll-behavior: smooth; }

        /* Navbar */
        .navbar-blur {
            backdrop-filter: blur(8px);
            background-color: rgba(255,255,255,0.7);
        }

        /* Buttons */
        .animated-button {
            transition: all 0.3s ease;
        }
        .animated-button:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Hero Gradient Background */
        .hero-gradient {
            position: relative;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 2s ease-in-out;
            background: linear-gradient(135deg, #e54646, #3b82f6);
        }
        .hero-content {
            position: relative;
            z-index: 10;
        }

        /* Marquee Logos */
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            gap: 4rem;
            animation: marquee 60s linear infinite;
        }
        .animate-marquee:hover {
            animation-play-state: paused;
        }
    </style>
<body class="bg-gray-50 font-sans text-gray-800">

    {{-- Navbar sticky blur --}}
    <nav class="fixed w-full z-50 navbar-blur shadow-md">
        <div class="container mx-auto flex justify-between items-center px-6 py-4">
            <div class="text-2xl font-bold text-blue-600">📦 Inventory</div>
            <ul id="navLinks" class="hidden md:flex gap-6">
                <li><a href="#features" class="hover:text-blue-600">Features</a></li>
                <li><a href="#about" class="hover:text-blue-600">About</a></li>
                <li><a href="#testimonials" class="hover:text-blue-600">Testimonials</a></li>
                <li><a href="{{ route('login') }}" class="bg-blue-600 text-white px-4 py-2 rounded animated-button">Login</a></li>
                <li><a href="{{ route('register') }}" class="border border-blue-600 text-blue-600 px-4 py-2 rounded animated-button">Register</a></li>
            </ul>
            <button id="menuBtn" class="md:hidden p-2 rounded hover:bg-gray-100">☰</button>
        </div>
        <ul id="mobileMenu" class="md:hidden hidden flex-col gap-2 bg-white px-6 pb-4">
            <li><a href="#features" class="block py-2">Features</a></li>
            <li><a href="#about" class="block py-2">About</a></li>
            <li><a href="#testimonials" class="block py-2">Testimonials</a></li>
            <li><a href="{{ route('login') }}" class="block py-2 bg-blue-600 text-white rounded text-center">Login</a></li>
            <li><a href="{{ route('register') }}" class="block py-2 border border-blue-600 rounded text-center text-blue-600">Register</a></li>
        </ul>
    </nav>

    {{-- Hero Section --}}
    <section class="hero-gradient relative flex items-center justify-center text-center text-white h-screen overflow-hidden">
        <div class="relative z-10 px-6 hero-content">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6" data-aos="fade-down">
                <span id="typed"></span>
            </h1>
            <p class="text-lg lg:text-2xl mb-10" data-aos="fade-up" data-aos-delay="200">
                Powerful Inventory Management for your business
            </p>
            <div class="flex justify-center gap-6" data-aos="zoom-in" data-aos-delay="400">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg animated-button">Login</a>
                <a href="{{ route('register') }}" class="border border-white text-white px-8 py-3 rounded-lg animated-button hover:bg-white hover:text-blue-600">Register</a>
            </div>
        </div>
    </section>

    {{-- Features --}}
    <section id="features" class="relative bg-gray-100 py-28">
        <div class="container mx-auto px-6 grid md:grid-cols-3 gap-10">
            @php
                $features = [
                    ['icon'=>'📦','title'=>'Product Management','desc'=>'Add, edit, archive, and manage your products easily.','color'=>'text-blue-600','delay'=>100],
                    ['icon'=>'🗂️','title'=>'Category Organization','desc'=>'Organize products by categories efficiently.','color'=>'text-indigo-600','delay'=>200],
                    ['icon'=>'⚠️','title'=>'Stock Alerts','desc'=>'Get notified when products reach minimum stock levels.','color'=>'text-green-600','delay'=>300],
                ];
            @endphp
            @foreach($features as $f)
            <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $f['delay'] }}">
                <div class="{{ $f['color'] }} text-5xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-semibold text-xl mb-2">{{ $f['title'] }}</h3>
                <p class="text-gray-600">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </section>

    {{-- About --}}
    <section id="about" class="relative bg-gray-50 py-28">
        <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h2 class="text-3xl font-bold mb-6">About Our System</h2>
                <p class="text-gray-700 mb-4">Our Inventory Management System helps companies track, manage, and organize their products efficiently.</p>
                <p class="text-gray-700">User-friendly dashboards, admin/user roles, and reporting tools keep inventory accurate and up-to-date.</p>
            </div>
            <div class="flex justify-center" data-aos="fade-left">
                <img src="{{ asset('images/logos/gambar.png') }}" alt="Inventory" class="rounded-2xl shadow-lg transition transform hover:scale-105">
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section id="testimonials" class="container mx-auto px-6 py-28">
        <h2 class="text-3xl font-bold text-center mb-12" data-aos="fade-up">What Users Say</h2>
        <div class="relative overflow-hidden rounded-2xl">
            <div id="testimonialSlider" class="flex transition-transform duration-700">
                @php
                    $testimonials = [
                        ['text'=>'"This system made managing our inventory so simple!"','author'=>'Alice','delay'=>0],
                        ['text'=>'"Love the dashboard and stock alerts!"','author'=>'Bob','delay'=>100],
                        ['text'=>'"Great for organizing products and categories!"','author'=>'Carol','delay'=>200],
                    ];
                @endphp
                @foreach($testimonials as $t)
                <div class="min-w-full bg-white p-10 text-center rounded-2xl shadow-lg" data-aos="zoom-in" data-aos-delay="{{ $t['delay'] }}">
                    <p class="text-gray-700 italic">{{ $t['text'] }}</p>
                    <p class="mt-4 font-semibold">– {{ $t['author'] }}</p>
                </div>
                @endforeach
            </div>
            <button id="prev" class="absolute top-1/2 left-2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100 transition">‹</button>
            <button id="next" class="absolute top-1/2 right-2 -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100 transition">›</button>
        </div>
    </section>

    {{-- Tools / Tech Stack --}}
    <section class="py-16 bg-gray-50 overflow-hidden">
        <div class="container mx-auto px-6 text-center mb-8">
            <h3 class="text-xl font-semibold text-gray-700">Built With Modern Technology</h3>
        </div>
        <div class="relative overflow-hidden">
            <div class="flex w-max gap-16 animate-marquee">
                @php
                    $logos = ['laravel.jpg','chatgpt.jpg','vscode.jpg','mysql.jpg','js.jpg','tailwindcss.png','html.jpg','css.jpg','github.jpg'];
                @endphp
                @foreach(array_merge($logos,$logos) as $logo)
                <img src="{{ asset('images/logos/'.$logo) }}" class="h-14 object-contain opacity-80 hover:opacity-100 transition">
                @endforeach
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-200 py-12">
        <div class="container mx-auto px-6 text-center space-y-6">
            <p>© {{ date('Y') }} Inventory Management System. All rights reserved.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-blue-600 px-6 py-3 rounded-lg text-white hover:bg-blue-700 transition">Login</a>
                <a href="{{ route('register') }}" class="border border-blue-600 px-6 py-3 rounded-lg text-blue-600 hover:bg-blue-600 hover:text-white transition">Register</a>
            </div>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));

        // Typing animation
        const typed = new Typed('#typed', {
            strings: ["Inventory Management System", "Manage Your Products", "Track Stock Easily"],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true
        });

        // Testimonials carousel
        const slider = document.getElementById('testimonialSlider');
        const totalSlides = slider.children.length;
        let slideIndex = 0;
        document.getElementById('next').addEventListener('click', () => {
            slideIndex = (slideIndex + 1) % totalSlides;
            slider.style.transform = `translateX(-${slideIndex * 100}%)`;
        });
        document.getElementById('prev').addEventListener('click', () => {
            slideIndex = (slideIndex - 1 + totalSlides) % totalSlides;
            slider.style.transform = `translateX(-${slideIndex * 100}%)`;
        });

        // Hero gradient automatic color change
        const gradients = [
            'linear-gradient(135deg, #2983A6, #74E8A4)',
            'linear-gradient(135deg, #833AB4, #FD1D1D, #FCB045)',
            'linear-gradient(135deg, #020024, 090979, #00D4FF)',
            'linear-gradient(135deg, #ec4899, #f472b6)',
            'linear-gradient(135deg, #3F5EFB, #FC466B)',
        ];
        let current = 0;
        const hero = document.querySelector('.hero-gradient');
        setInterval(() => {
            current = (current + 1) % gradients.length;
            hero.style.background = gradients[current]; // transisi sekarang smooth karena CSS transition
        }, 5000);
    </script>

</body>
</html>