@extends('layouts.app')

@section('title', 'Book List')

@section('content')
<div class="row">
    <!-- Search and Filter Card -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2"></i>Search & Filter
                </h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('books.index') }}" class="row g-3">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ $filters['search'] ?? '' }}" 
                               placeholder="Search by title, author, or ISBN...">
                    </div>
                    
                    <!-- Category Filter -->
                    <div class="col-md-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ ($filters['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Author Filter -->
                    <div class="col-md-3">
                        <label for="author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="author" name="author" 
                               value="{{ $filters['author'] ?? '' }}" 
                               placeholder="Filter by author...">
                    </div>
                    
                    <!-- Publisher Filter -->
                    <div class="col-md-2">
                        <label for="publisher" class="form-label">Publisher</label>
                        <input type="text" class="form-control" id="publisher" name="publisher" 
                               value="{{ $filters['publisher'] ?? '' }}" 
                               placeholder="Filter by publisher...">
                    </div>
                    
                    <!-- Date Filters -->
                    <div class="col-md-3">
                        <label for="published_from" class="form-label">Published From</label>
                        <input type="date" class="form-control" id="published_from" name="published_from" 
                               value="{{ $filters['published_from'] ?? '' }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label for="published_to" class="form-label">Published To</label>
                        <input type="date" class="form-control" id="published_to" name="published_to" 
                               value="{{ $filters['published_to'] ?? '' }}">
                    </div>
                    
                    <!-- Per Page -->
                    <div class="col-md-2">
                        <label for="per_page" class="form-label">Per Page</label>
                        <select class="form-select" id="per_page" name="per_page">
                            <option value="5" {{ ($filters['per_page'] ?? '') == 5 ? 'selected' : '' }}>5</option>
                            <option value="10" {{ ($filters['per_page'] ?? '10') == '10' ? 'selected' : '' }}>10</option>
                            <option value="15" {{ ($filters['per_page'] ?? '') == 15 ? 'selected' : '' }}>15</option>
                            <option value="25" {{ ($filters['per_page'] ?? '') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ ($filters['per_page'] ?? '') == 50 ? 'selected' : '' }}>50</option>
                        </select>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="btn-group w-100" role="group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i>Search
                            </button>
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Books Table -->
    <div class="col-12">
        <div class="card table-card">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <h5 class="mb-0">
                    <i class="fas fa-book me-2"></i>Books ({{ $books->total() }})
                </h5>
                <a href="{{ route('books.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus me-1"></i>Add New Book
                </a>
            </div>
            <div class="card-body p-0">
                @if($books->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No books found</h5>
                        <p class="text-muted">Try adjusting your search criteria or add a new book.</p>
                        <a href="{{ route('books.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add Book
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">#</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>ISBN</th>
                                    <th>Publisher</th>
                                    <th>Category</th>
                                    <th>Published Date</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($books as $index => $book)
                                    <tr>
                                        <td class="ps-4">{{ $books->firstItem() + $index }}</td>
                                        <td>
                                            <strong>{{ $book->title }}</strong>
                                        </td>
                                        <td>{{ $book->author }}</td>
                                        <td>
                                            <code class="small">{{ $book->isbn }}</code>
                                        </td>
                                        <td>{{ $book->publisher }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $book->category->name }}</span>
                                        </td>
                                        <td>{{ $book->published_date->format('M d, Y') }}</td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('books.show', $book->id) }}" 
                                                   class="btn btn-outline-info btn-action"
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('books.edit', $book->id) }}" 
                                                   class="btn btn-outline-primary btn-action"
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('books.destroy', $book->id) }}" 
                                                      class="d-inline" onsubmit="return confirmDelete('{{ $book->title }}')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-action" 
                                                            title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
            <!-- Pagination -->
            @if($books->hasPages())
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $books->firstItem() }} to {{ $books->lastItem() }} of {{ $books->total() }} entries
                        </div>
                        <nav>
                            {{ $books->appends(request()->query())->links() }}
                        </nav>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
