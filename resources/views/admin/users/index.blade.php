@extends('layouts.admin')

@section('title', 'Manage Users | Grand Luxe Admin')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h2 class="font-serif text-2xl font-bold text-white">Registered Users</h2>
            <p class="text-xs text-slate-400">Total of {{ $users->total() }} accounts in the database</p>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="p-4 rounded-2xl bg-slate-950/60 border border-slate-800">
        <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <div class="sm:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by user name or email..." class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white placeholder-slate-500 focus:ring-1 focus:ring-gold-500 focus:border-gold-500">
            </div>

            <div>
                <select name="role" class="w-full px-3.5 py-2 rounded-xl bg-slate-900 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-gold-500">
                    <option value="all">All Roles</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User (Guest)</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs transition-colors">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'role']))
                    <a href="{{ route('admin.users.index') }}" class="p-2 rounded-xl bg-slate-800 text-slate-400 hover:text-white" title="Reset">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-slate-950/60 rounded-3xl border border-slate-800 shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-slate-900/80 border-b border-slate-800 text-slate-400 uppercase tracking-wider font-semibold">
                        <th class="py-4 px-6">User</th>
                        <th class="py-4 px-6">Email Address</th>
                        <th class="py-4 px-6">Role</th>
                        <th class="py-4 px-6">Bookings Made</th>
                        <th class="py-4 px-6">Registered Date</th>
                        <th class="py-4 px-6 text-right">Role Management</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-900/50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 text-gold-400 font-bold flex items-center justify-center text-xs">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold text-white text-sm">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-300">
                                {{ $u->email }}
                            </td>
                            <td class="py-4 px-6">
                                @if($u->isAdmin())
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-purple-950 text-purple-300 border border-purple-800">
                                        👑 Administrator
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase bg-slate-800 text-slate-300 border border-slate-700">
                                        👤 Guest User
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-300 font-medium">
                                <span class="px-2 py-0.5 rounded-lg bg-slate-900 border border-slate-800 font-mono text-gold-400">
                                    {{ $u->reservations_count }} Stays
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-400">
                                {{ $u->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($u->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.role', $u->id) }}" class="inline-flex items-center gap-1.5">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" onchange="this.form.submit()" class="py-1 px-2 rounded-lg bg-slate-900 border border-slate-700 text-[11px] text-slate-200 focus:ring-1 focus:ring-gold-500 cursor-pointer">
                                                <option value="user" {{ $u->role === 'user' ? 'selected' : '' }}>User</option>
                                                <option value="admin" {{ $u->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </form>

                                        @if($u->reservations_count === 0)
                                            <form method="POST" action="{{ route('admin.users.destroy', $u->id) }}" onsubmit="return confirm('Are you sure you want to delete user {{ $u->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 rounded-lg bg-slate-800 text-red-400 hover:bg-red-500 hover:text-white" title="Delete User">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <span class="text-[10px] text-slate-500 italic">Current Session</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection
