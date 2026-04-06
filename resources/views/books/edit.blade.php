@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-edit me-2"></i>Edit Book
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('books.update', $book->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-12">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" 
                                   value="{{ old('title', $book->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Author -->
                        <div class="col-md-6">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('author') is-invalid @enderror" 
                                   id="author" name="author" 
                                   value="{{ old('author', $book->author) }}" 
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- ISBN -->
                        <div class="col-md-6">
                            <label for="isbn" class="form-label">ISBN <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" name="isbn" 
                                   value="{{ old('isbn', $book->isbn) }}" 
                                   placeholder="978-0-13-468599-1"
                                   required>
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter a valid ISBN-10 or ISBN-13</div>
                        </div>
                        
                        <!-- Publisher -->
                        <div class="col-md-6">
                            <label for="publisher" class="form-label">Publisher <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('publisher') is-invalid @enderror" 
                                   id="publisher" name="publisher" 
                                   value="{{ old('publisher', $book->publisher) }}" 
                                   required>
                            @error('publisher')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Published Date -->
                        <div class="col-md-6">
                            <label for="published_date" class="form-label">Published Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('published_date') is-invalid @enderror" 
                                   id="published_date" name="published_date" 
                                   value="{{ old('published_date', $book->published_date->format('Y-m-d')) }}" 
                                   required>
                            @error('published_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div class="col-12">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" 
                                    required>
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" 
                                      rows="4"
                                      placeholder="Enter a brief description of the book...">{{ old('description', $book->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Submit Buttons -->
                        <div class="col-12 mt-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Book
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
