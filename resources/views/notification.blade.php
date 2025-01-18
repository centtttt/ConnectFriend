@extends('layouts.app')

@section('content')
    <header class="text-center mb-4">
        <h1>Notification</h1>
        <p>Recently Notification.</p>
    </header>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="m-4">
        <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="friend-requests-tab" data-bs-toggle="tab" href="#friend-requests" role="tab"
                    aria-controls="friend-requests" aria-selected="true">Friend Requests</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="messages-tab" data-bs-toggle="tab" href="#messages" role="tab" aria-controls="messages"
                    aria-selected="false">Messages</a>
            </li>
        </ul>

        <div class="tab-content" id="notificationTabsContent">
            <div class="tab-pane fade show active" id="friend-requests" role="tabpanel" aria-labelledby="friend-requests-tab">
                <h5>Friend Requests</h5>
                <ul class="list-group mb-3">
                    @if ($friend->isEmpty())
                        <li class="list-group-item text-start">
                            <span>No friend requests at the moment.</span>
                        </li>
                    @else
                        @foreach ($friend as $friends)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>You have friend request from <span class="text-primary">{{ $friends->user->name }}</span></span>
                                <span class="text-muted">
                                    {{ $friends->created_at->diffForHumans() }}
                                </span>
                                <div class="d-flex flex-row" style="gap: 0.5rem;">
                                    <form action="{{ route('notification.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="friend_id" value="{{ $friends->user_id }}">
                                        <button type="submit" class="btn btn-primary btn-sm">Accept</button>
                                    </form>

                                    <form action="{{ route('notification.destroy', $friends->friend_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <input type="hidden" name="friend_id" value="{{ $friends->user_id }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                <h5>Messages</h5>
                <ul class="list-group mb-2">
                    @forelse ($messages as $message)
                        <li class="list-group-item">
                            <h5 class="card-title">{{ $message->user->name }}</h5>
                            <p class="card-text"></p>
                            <p class="text-muted">Received: 5 january 2025</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection