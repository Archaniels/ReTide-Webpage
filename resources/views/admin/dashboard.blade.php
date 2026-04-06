@extends('layouts.admin')

@section('header', 'Admin Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Users Card -->
    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-lg p-6 flex items-center transition-transform hover:scale-[1.02] duration-300">
        <div class="p-4 bg-primary/10 rounded-xl text-primary mr-5">
            <i class="fas fa-users text-2xl"></i>
        </div>
        <div>
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Total Users</p>
            <p class="text-3xl font-bold text-white">{{ $usersCount }}</p>
        </div>
    </div>

    <!-- Products Card -->
    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-lg p-6 flex items-center transition-transform hover:scale-[1.02] duration-300">
        <div class="p-4 bg-primary/10 rounded-xl text-primary mr-5">
            <i class="fas fa-store text-2xl"></i>
        </div>
        <div>
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Total Products</p>
            <p class="text-3xl font-bold text-white">{{ $productsCount }}</p>
        </div>
    </div>

    <!-- Blogs Card -->
    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-lg p-6 flex items-center transition-transform hover:scale-[1.02] duration-300">
        <div class="p-4 bg-primary/10 rounded-xl text-primary mr-5">
            <i class="fas fa-blog text-2xl"></i>
        </div>
        <div>
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Total Blogs</p>
            <p class="text-3xl font-bold text-white">{{ $blogsCount }}</p>
        </div>
    </div>

    <!-- Donations Card -->
    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-lg p-6 flex items-center transition-transform hover:scale-[1.02] duration-300">
        <div class="p-4 bg-primary/10 rounded-xl text-primary mr-5">
            <i class="fas fa-hand-holding-heart text-2xl"></i>
        </div>
        <div>
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Total Donations</p>
            <p class="text-3xl font-bold text-white">{{ $donationsCount }}</p>
        </div>
    </div>
</div>

<div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="p-8">
        <h2 class="text-2xl font-bold mb-4 text-white">Welcome to <span class="text-primary">ReTide Admin Panel</span></h2>
        <p class="text-secondary leading-relaxed max-w-2xl mb-6">
            Everything you need to manage your platform is right here. Use the navigation sidebar to access different administrative modules, approve products, manage content, and monitor the community.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-8">
            <div class="flex items-start p-4 bg-dark-lighter rounded-xl border border-gray-800">
                <div class="bg-primary/20 text-primary p-3 rounded-lg mr-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-1">Secure Management</h4>
                    <p class="text-sm text-secondary">Advanced controls for user accounts and roles.</p>
                </div>
            </div>
            <div class="flex items-start p-4 bg-dark-lighter rounded-xl border border-gray-800">
                <div class="bg-primary/20 text-primary p-3 rounded-lg mr-4">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-1">Real-time Overview</h4>
                    <p class="text-sm text-secondary">Monitor donations and marketplace activity instantly.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
