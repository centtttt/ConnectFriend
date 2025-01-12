@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Notifications</h1>
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <span>You have friend request</span>
                <span class="text-muted">
                        45 minutes ago
                </span>
                <a href="" class="btn btn-primary btn-sm">Mark as Read</a>
            </li>
        </ul>


        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Notification Details</h5>
                <p class="card-text">Hello</p>

                <p class="text-muted">Received: 5 january 2025</p>
                <p class="text-muted">Status: Read</p>
            </div>
        </div>
    </div>
@endsection
