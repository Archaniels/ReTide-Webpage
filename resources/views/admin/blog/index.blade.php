@extends('layouts.admin')

@section('header', 'Manage Blogs')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <p class="text-secondary">Review, add, edit, or delete your platform's blog posts.</p>
    </div>
    <a href="{{ route('admin.blogs.create') }}" class="inline-flex items-center bg-primary hover:bg-primary/90 text-black font-bold py-2.5 px-6 rounded-xl transition-all shadow-lg shadow-primary/20">
        <i class="fas fa-plus mr-2 text-sm"></i> Create New Post
    </a>
</div>

<div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-lighter text-secondary text-xs font-bold uppercase tracking-widest border-b border-gray-800">
                    <th class="px-6 py-4">Preview</th>
                    <th class="px-6 py-4">Title & Excerpt</th>
                    <th class="px-6 py-4">Published On</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($blogs as $blog)
                <tr class="hover:bg-gray-800/30 transition-colors duration-150">
                    <td class="px-6 py-4">
                        @if($blog->image_path)
                            <div class="h-16 w-24 overflow-hidden rounded-lg border border-gray-700">
                                <img src="{{ asset('storage/' . $blog->image_path) }}" alt="{{ $blog->title }}" class="h-full w-full object-cover">
                            </div>
                        @else
                            <div class="h-16 w-24 bg-gray-800 border border-gray-700 rounded-lg flex items-center justify-center text-gray-600">
                                <i class="fas fa-image text-xl"></i>
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-white mb-1 truncate max-w-xs md:max-w-md">{{ $blog->title }}</div>
                        <div class="text-xs text-secondary truncate max-w-xs md:max-w-md opacity-60">
                            {{ Str::limit(strip_tags($blog->content), 80) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-secondary">
                        <div class="flex flex-col">
                            <span class="text-white">{{ $blog->created_at->format('M d, Y') }}</span>
                            <span class="text-xs opacity-50">{{ $blog->created_at->diffForHumans() }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" 
                               class="text-xs bg-gray-800 hover:bg-primary/20 text-secondary hover:text-primary border border-gray-700 hover:border-primary/30 px-3 py-1.5 rounded-lg transition-all" title="Edit Post">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-xs bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 hover:border-red-500/40 px-3 py-1.5 rounded-lg transition-all" title="Delete Post">
                                    <i class="fas fa-trash-alt mr-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center text-secondary">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-feather-alt text-5xl mb-4 opacity-10"></i>
                            <p class="text-lg font-medium mb-1">No blog posts yet</p>
                            <p class="text-sm opacity-60 mb-6">Start sharing news and updates with your community.</p>
                            <a href="{{ route('admin.blogs.create') }}" class="text-primary hover:underline font-bold">
                                Create your first post &rarr;
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
