@extends('layouts.admin')

@section('header', 'Manage Users')

@section('content')
<div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="p-6 border-b border-gray-800 bg-dark-lighter/50 flex justify-between items-center">
        <h3 class="text-lg font-bold text-white">System Users</h3>
        <span class="text-secondary text-sm">{{ $users->count() }} total users</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-lighter text-secondary text-xs font-bold uppercase tracking-widest border-b border-gray-800">
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4 text-center">Role</th>
                    <th class="px-6 py-4">Registered At</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @foreach($users as $user)
                <tr class="hover:bg-gray-800/30 transition-colors duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-primary font-bold mr-3 border border-gray-700">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="text-sm font-bold text-white">{{ $user->name }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-secondary">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $isAdmin = ($user->role === 'admin');
                            $badgeClass = $isAdmin 
                                ? 'bg-primary/20 text-primary border-primary/30' 
                                : 'bg-blue-500/20 text-blue-400 border-blue-500/30';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border {{ $badgeClass }}">
                            {{ strtoupper($user->role ?? 'user') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-secondary">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.accounts.updateRole', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->role === 'admin')
                                        <input type="hidden" name="role" value="user">
                                        <button type="submit" class="text-xs bg-gray-800 hover:bg-orange-500/20 text-orange-400 border border-gray-700 hover:border-orange-500/30 px-3 py-1.5 rounded-lg transition-all" title="Demote to User">
                                            Demote
                                        </button>
                                    @else
                                        <input type="hidden" name="role" value="admin">
                                        <button type="submit" class="text-xs bg-primary/10 hover:bg-primary/20 text-primary border border-primary/20 hover:border-primary/40 px-3 py-1.5 rounded-lg transition-all" title="Promote to Admin">
                                            Make Admin
                                        </button>
                                    @endif
                                </form>
                                
                                <form action="{{ route('admin.accounts.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 hover:border-red-500/40 px-3 py-1.5 rounded-lg transition-all" title="Delete User">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-secondary italic bg-gray-800/50 px-3 py-1.5 rounded-lg border border-gray-800">You</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
