@extends('layouts.app')

@section('title', 'About Us | Grand Luxe Hotel & Resort')

@section('content')
<!-- About Hero -->
<section class="relative py-20 bg-charcoal-950 text-white overflow-hidden">
    <div class="absolute inset-0 opacity-30">
        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&w=1600&q=80" alt="About Grand Luxe" class="w-full h-full object-cover">
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-400">Our Heritage & Vision</span>
        <h1 class="font-serif text-4xl sm:text-6xl font-bold mt-2 mb-4">Timeless Luxury, Redefined</h1>
        <p class="text-gray-300 max-w-2xl mx-auto text-sm sm:text-base font-light">
            Founded with a passion for world-class hospitality, Grand Luxe Hotel & Resort provides a sanctuary of refined elegance and serenity.
        </p>
    </div>
</section>

<!-- About Content Details -->
<section class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <span class="text-xs font-bold uppercase tracking-[0.25em] text-gold-600">The Grand Story</span>
            <h2 class="font-serif text-3xl sm:text-4xl font-bold text-charcoal-900 mt-2 mb-6">A Legacy of Five-Star Hospitality</h2>
            <p class="text-gray-600 text-sm leading-relaxed mb-4">
                Since our grand opening, Grand Luxe has welcomed dignitaries, celebrities, and travelers from across the globe seeking extraordinary escapes. Every detail of our architecture is an ode to classical European elegance infused with modern tropical warmth.
            </p>
            <p class="text-gray-600 text-sm leading-relaxed mb-6">
                Our team is trained under the highest international standards of concierge and butler service, ensuring that your every preference is anticipated before you even ask.
            </p>
            <div class="grid grid-cols-3 gap-6 pt-4 border-t border-gold-200">
                <div>
                    <span class="font-serif text-3xl font-bold text-gold-600">150+</span>
                    <p class="text-xs text-gray-500 mt-1">Luxury Suites</p>
                </div>
                <div>
                    <span class="font-serif text-3xl font-bold text-gold-600">98%</span>
                    <p class="text-xs text-gray-500 mt-1">Guest Satisfaction</p>
                </div>
                <div>
                    <span class="font-serif text-3xl font-bold text-gold-600">25+</span>
                    <p class="text-xs text-gray-500 mt-1">Global Awards</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=600&q=80" alt="Resort Pool" class="rounded-2xl shadow-lg w-full h-64 object-cover">
            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=600&q=80" alt="Luxury Room" class="rounded-2xl shadow-lg w-full h-64 object-cover mt-8">
        </div>
    </div>
</section>
@endsection
