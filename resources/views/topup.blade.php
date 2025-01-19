@extends('layouts.app')

@section('content')
    <header class="text-center mb-4">
        <h1>Top Up Coins</h1>
        <p>Your current balance: <strong>{{ $profile->coins }}</strong></p>

        <div class="mt-4">
            <a href="{{ route('topup.edit', $profile->user_id) }}" class="btn btn-primary btn-lg" style="padding: 12px 25px; font-size: 18px; border-radius: 10px;">
                Top Up Now
            </a>
        </div>
    </header>
@endsection
