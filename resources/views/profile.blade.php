@extends('layouts.app')

@section('content')
    <div class="container mt-1">
        <header class="text-center mb-4">
            <h1>My Profile</h1>
            <p>Manage your personal information and keep it up to date.</p>
        </header>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-header bg-dark text-white text-center">
                        <h3 class="mb-0">Profile Details</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($users as $user)
                        <div class="text-center mb-4">
                            <div class="d-flex flex-column align-items-center justify-content-center">
                                <img src="{{ asset($user->profile->profileURL ? 'storage/' . $user->profile->profileURL : 'images/userdummy.png') }}" alt="error" class="rounded-circle shadow m-4 mb-1" style="width: 150px; height: 150px; object-fit: cover;">
                                <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Edit Profile Picture
                                    </button>
                                </div>
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
                                    <a href="{{ $user->profile->linkedin }}" target="_blank"> {{ $user->profile->linkedin }}</a>
                                </li>
                                <li class="list-group-item">
                                    <strong>Mobile Number:</strong> {{ $user->profile->mobile_number }}
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex flex-col">
                                        <div class="d-flex align-items-center">
                                            <strong>Coins: <span class="fw-normal text-success">{{ $user->profile->coins }}</span></strong> 
                                        </div>
                                        <div class="d-flex" style="margin-left: auto;">
                                            <a href="{{ route('topup.index') }}">
                                                <button class="btn btn-outline-success">Top Up Coins</button>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <div class="text-center mb-4 mt-2">
                                    <h6 class="fw-bold">Visibility Settings</h6>
                                    <form action="{{ route('profile.store') }}" method="POST" class="d-inline">
                                        @csrf
                                        @if ($user->visibility == true)
                                            <button type="submit" name="visibility" value="disappear" class="btn btn-danger w-100">
                                                Disappear (50 Coins)
                                            </button>
                                        @else
                                            <button type="submit" name="visibility" value="reappear" class="btn btn-success w-100">
                                                Reappear (5 Coins)
                                            </button>
                                        @endif
                                    </form>
                                </div>
                                <li class="list-group-item">
                                    <strong>Friend List:</strong>
                                    <div class="row">
                                        @foreach ($Userfriend as $uf)
                                            <div class="card shadow-sm border-0 h-100">
                                                <div class="d-flex flex-row justify-content-center align-items-center card-body gap-3">
                                                    <img src="{{ asset($uf->friend->profile->profileURL ? 'storage/' . $uf->friend->profile->profileURL : 'images/userdummy.png') }}" alt="error" class="rounded-circle shadow" style="width: 40px; height: 40px; object-fit: cover;">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="fw-bold mb-0">{{ $uf->friend->name }}</h6>
                                                        <p class="text-muted mb-0" style="font-size: 0.85rem;">{{ $uf->friend->profile->gender }}</p>
                                                    </div>
                                                    <div class="d-flex flex-row" style="margin-left: auto; gap: 0.5rem;">
                                                        <div>
                                                            <form action="{{ route('profile.destroy', $uf->friend->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm btn-outline-primary">Remove Friend</button>
                                                            </form>
                                                        </div>
                                                        
                                                        <div>
                                                            <a href="{{ route('friend-profile.show', $uf->friend->id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                                                        </div>
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

    <!-- modal -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Edit Profile Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="profilePhoto" class="form-label">Choose a new profile picture</label>
                            <input class="form-control" type="file" id="profilePhoto" name="profilePhoto" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Upload Photo</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
