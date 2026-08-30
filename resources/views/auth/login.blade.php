@extends('layouts.app')

@section('title', 'Sign In | Grand Luxe Hotel & Resort')

@section('content')
<div class="min-h-[calc(100vh-280px)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
    
    <!-- Background subtle luxury decoration -->
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-gold-400 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-gold-600 blur-3xl"></div>
    </div>

    <div class="max-w-md w-full relative z-10">
        
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-14 h-14 rounded-2xl gold-gradient flex items-center justify-center text-white font-serif font-bold text-2xl mx-auto shadow-lg shadow-gold-500/25 mb-4">
                L
            </div>
            <h2 class="font-serif text-3xl font-bold text-charcoal-900">Welcome Back</h2>
            <p class="text-sm text-gray-500 mt-2">Sign in to manage your hotel reservations & stay privileges</p>
        </div>

        <!-- Demo Credentials Helper Card -->
        <div class="mb-6 p-4 rounded-2xl bg-gold-50/80 border border-gold-200 shadow-sm" x-data="{
            fill(email, pass) {
                document.getElementById('email').value = email;
                document.getElementById('password').value = pass;
            }
        }">
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-gold-500 text-white text-[10px] font-bold">i</span>
                <span class="text-xs font-bold uppercase tracking-wider text-gold-900">Demo Accounts (Click to Fill)</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <button type="button" @click="fill('admin@hotel.com', 'password')" class="text-left px-3 py-2 rounded-xl bg-white border border-gold-200 hover:border-gold-400 hover:shadow transition-all group">
                    <p class="text-xs font-bold text-purple-700 group-hover:text-purple-900">👑 Admin</p>
                    <p class="text-[11px] text-gray-500 truncate">admin@hotel.com</p>
                </button>
                <button type="button" @click="fill('user@hotel.com', 'password')" class="text-left px-3 py-2 rounded-xl bg-white border border-gold-200 hover:border-gold-400 hover:shadow transition-all group">
                    <p class="text-xs font-bold text-gold-700 group-hover:text-gold-900">👤 Guest User</p>
                    <p class="text-[11px] text-gray-500 truncate">user@hotel.com</p>
                </button>
            </div>
        </div>

        <!-- Login Form Card -->
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-gold-100">
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" placeholder="you@example.com" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-charcoal-900 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required placeholder="••••••••" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-gold-500 focus:border-gold-500 transition-colors">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="w-4 h-4 text-gold-600 focus:ring-gold-500 border-gray-300 rounded">
                        <span class="ml-2 text-xs text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-xs font-semibold text-gold-700 hover:text-gold-800">Forgot password?</a>
                </div>

                <button type="submit" class="w-full py-3.5 px-4 rounded-xl gold-gradient text-white font-bold text-sm shadow-md shadow-gold-500/25 hover:shadow-lg hover:shadow-gold-500/40 hover:scale-[1.01] transition-all">
                    Sign In to Account
                </button>
            </form>

            <div class="mt-6 text-center text-xs text-gray-500 border-t border-gray-100 pt-6">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="font-bold text-gold-700 hover:text-gold-800 ml-1">Create an Account</a>
            </div>
        </div>
    </div>
</div>
@endsection
