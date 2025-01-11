@extends('layouts.app')

@section('content')
    <div class="container mt-1">
        <header class="text-center mb-4">
            <h1>My Profile</h1>
            <p>Manage your personal information and keep it up to date.</p>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h3 class="mb-0">Profile Details</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($users as $user)
                            <div class="text-center mb-4">
                                <img src="{{ $user->profile->profileURL ?? asset('images/userdummy.png') }}" alt="error" class="rounded-circle shadow m-4 mb-1" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>

                            <h5 class="text-center fw-bold mb-3">{{ $user->name }}</h5>

                            <div class="text-center">
                                <strong class="fw-bold">Job Fields:</strong>
                                <ul class="list-unstyled">
                                    @foreach ($jobfield as $jf)
                                        <li class="badge bg-primary text-white mx-1">{{ $jf->jobfieldname }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <strong>Gender:</strong> {{ $user->profile->gender }}
                                </li>
                                <li class="list-group-item">
                                    <strong>LinkedIn:</strong> 
                                    <a href="{{ $user->profile->linkedin }}" target="_blank">{{ $user->profile->linkedin }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Mobile Number:</strong> {{ $user->profile->mobile_number }}
                                </li>
                                <li class="list-group-item">
                                    <strong>Coins:</strong> {{ $user->profile->coins }}
                                    <button class="btn btn-outline-success ml-4">Top Up Coins</button>
                                </li>
                                <li class="list-group-item">
                                    <strong>Friend List:</strong>
                                    <div class="row">
                                        @foreach ($users as $user)
                                            <div class="card shadow-sm border-0 h-100">
                                                <div class="d-flex flex-row justify-content-center align-items-center card-body gap-3">
                                                    <img src="{{ $user->profile->profileURL ?? asset('images/userdummy.png') }}" alt="error" class="rounded-circle shadow" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="fw-bold mb-0">{{ $user->name }}</h6>
                                                        <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ $user->profile->gender }}</p>
                                                    </div>
                                                    <div class="d-flex flex-column" style="margin-left: auto;">
                                                        <a href="{{ route('profile', $user->id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
