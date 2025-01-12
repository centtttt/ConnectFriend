@extends('layouts.app')

@section('content')
    <div class="container mt-1">
        <header class="text-center mb-4">
            <h1>Messages</h1>
            <p>Chat with other users seamlessly.</p>
        </header>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Friends</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($users as $user)
                            <li class="list-group-item d-flex align-items-center">
                                <img src="{{ asset($user->user->profile->profileURL ? 'storage/' . $user->user->profile->profileURL : 'images/userdummy.png') }}" 
                                     alt="User" 
                                     class="rounded-circle me-3" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <h6 class="mb-0">{{ $user->user->name }}</h6>
                                    <small class="text-muted">Last seen: Recently</small>
                                </div>
                                <a href="{{ route('message.show', $user->user_id) }}" 
                                   class="btn btn-sm btn-outline-primary ms-auto">
                                    Chat
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $currentChatUser->name ?? 'Select a contact' }}</h5>
                        <small>Online</small>
                    </div>
                    <div class="card-body" style="height: 500px; overflow-y: auto; background-color: #f7f7f7;">
                        @forelse($messages as $message)
                            @if($message->sender_id === auth()->id())
                                {{-- Pesan dari Pengguna --}}
                                <div class="d-flex justify-content-end mb-3">
                                    <div class="bg-primary text-white p-3 rounded" style="max-width: 70%;">
                                        <p class="mb-0">{{ $message->message }}</p>
                                        <small class="d-block text-end mt-1">{{ $message->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                            @else
                                {{-- Pesan dari Orang Lain --}}
                                <div class="d-flex justify-content-start mb-3">
                                    <div class="bg-success text-white p-3 rounded" style="max-width: 70%;">
                                        <p class="mb-0">{{ $message->message }}</p>
                                        <small class="d-block text-start mt-1">{{ $message->created_at->format('H:i') }}</small>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p class="text-muted text-center">No messages yet. Start a conversation!</p>
                        @endforelse
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('message.store') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="receiver_id" value="{{ $currentChatUser->id ?? '' }}">
                            <input type="text" name="content" class="form-control me-2" placeholder="Type a message" required>
                            <button type="submit" class="btn btn-success">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
