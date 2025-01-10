@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registration') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('createregistration') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>

                            <div class="col-md-6">
                                <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>

                                </select>

                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="options" class="col-md-4 col-form-label text-md-end">Jobfield (Min: 3)</label>
                            <div class="col-md-6">
                                <div id="options-container">
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control" placeholder="Enter Option">
                                        <button type="button" class="btn btn-danger remove-option">Delete</button>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control" placeholder="Enter Option">
                                        <button type="button" class="btn btn-danger remove-option">Delete</button>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="text" name="options[]" class="form-control" placeholder="Enter Option">
                                        <button type="button" class="btn btn-danger remove-option">Delete</button>
                                    </div>
                                </div>
                                @error('options')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <button type="button" id="add-option" class="btn btn-secondary mb-2">Add Option</button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="linkedinusername" class="col-md-4 col-form-label text-md-end">{{ __('LinkedIn Username') }}</label>

                            <div class="col-md-6">
                                <input id="linkedinusername" type="text" class="form-control @error('linkedinusername') is-invalid @enderror" name="linkedinusername" required autocomplete="linkedinusername" placeholder="https://www.linkedin.com/in/<username>">

                                @error('linkedinusername')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="mobilenumber" class="col-md-4 col-form-label text-md-end">{{ __('Mobile Number') }}</label>

                            <div class="col-md-6">
                                <input id="mobilenumber" type="text" class="form-control @error('mobilenumber') is-invalid @enderror" name="mobilenumber" required autocomplete="mobilenumber" placeholder="Ex: 081323455678">

                                @error('mobilenumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="reference" class="col-md-4 col-form-label text-md-end">{{ __('Reference') }}</label>

                            <div class="col-md-6">
                                <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" required autocomplete="reference"  placeholder="Enter reference code or source">

                                @error('reference')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="price" class="col-md-4 col-form-label text-md-end">{{ __('Registration Price') }}</label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ $price }}" readonly>

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const container = document.getElementById('options-container');

    document.getElementById('add-option').addEventListener('click', () => {
        container.insertAdjacentHTML('beforeend', `
            <div class="input-group mb-2">
                <input type="text" name="options[]" class="form-control" placeholder="Enter Option">
                <button type="button" class="btn btn-danger remove-option">Delete</button>
            </div>
        `);
    });

    container.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-option')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
