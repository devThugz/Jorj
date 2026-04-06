@extends('layouts.app')

@section('title', 'View Book')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-book me-2"></i>Book Details
                </h5>
                <div>
                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Title -->
                    <div class="col-12">
                        <label class="form-label text-muted">Title</label>
                        <p class="fs-5 fw-bold">{{ $book->title }}</p>
                    </div>
                    
                    <!-- Author & ISBN -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Author</label>
                        <p>{{ $book->author }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label text-muted">ISBN</label>
                        <p><code>{{ $book->isbn }}</code></p>
                    </div>
                    
                    <!-- Publisher & Published Date -->
                    <div class="col-md-6">
                        <label class="form-label text-muted">Publisher</label>
                        <p>{{ $book->publisher }}</p>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label text-muted">Published Date</label>
                        <p>{{ $book->published_date->format('F d, Y') }}</p>
                    </div>
                    
                    <!-- Category -->
                    <div class="col-12">
                        <label class="form-label text-muted">Category</label>
                        <p>
                            <span class="badge bg-info fs-6">{{ $book->category->name }}</span>
                        </p>
                    </div>
                    
                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label text-muted">Description</label>
                        <p class="text-break">
                            {{ $book->description ?? 'No description available.' }}
                        </p>
                    </div>
                    
                    <!-- Metadata -->
                    <div class="col-12 mt-4 pt-3 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Created: {{ $book->created_at->format('F d, Y g:i A') }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    <i class="fas fa-calendar-edit me-1"></i>
                                    Updated: {{ $book->updated_at->format('F d, Y g:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light">
                <form method="POST" action="{{ route('books.destroy', $book->id) }}" 
                      class="d-inline" onsubmit="return confirmDelete('{{ $book->title }}')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
