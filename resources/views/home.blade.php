@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Dashboard') }}</h4>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="text-muted">{{ __('You are logged in!') }}</p>

                    <div class="mt-4">
                        <h5 class="fw-bold">Admin Panel</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-folder"></i> Manage Categories
                                </a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-success">
                                    <i class="fas fa-box"></i> Manage Products
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
