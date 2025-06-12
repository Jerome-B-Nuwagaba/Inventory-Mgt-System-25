@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-black">Chats</h1>
        <a href="{{ route('chats.create') }}" class="bg-blue-900 hover:bg-blue-950 text-black font-bold py-2 px-4 rounded-full inline-flex items-center transition duration-300 ease-in-out transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            New Chat
        </a>
    </div>
    
    <div class="bg-gray-800 shadow-lg rounded-lg p-6">
        @if($chats->isEmpty())
            <div class="text-center py-8">
                <p class="text-black-400 mb-4">No chats found.</p>
                <a href="{{ route('chats.create') }}" class="bg-blue-900 hover:bg-blue-950 text-white font-bold py-2 px-4 rounded-full inline-flex items-center transition duration-300 ease-in-out transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Start a New Chat
                </a>
            </div>
        @else
            <ul class="divide-y divide-gray-700">
                @foreach($chats as $chat)
                    <li class="py-4 hover:bg-gray-700 transition duration-300 ease-in-out">
                        <a href="{{ route('chats.show', $chat) }}" class="block">
                            <div class="flex justify-between">
                                <div>
                                    <p class="text-sm font-medium text-white">
                                        {{ $chat->sender_id === auth()->id() ? $chat->receiver->name : $chat->sender->name }}
                                    </p>
                                    <p class="text-sm text-gray-400">{{ Str::limit($chat->message, 50) }}</p>
                                </div>
                                <div class="text-sm text-gray-400">
                                    {{ $chat->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection 