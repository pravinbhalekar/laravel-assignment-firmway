@extends('layouts.app')
@section('title')
    {{request()->id ? 'Edit Post' : 'Add Post' }}
@endsection

@section('content')
    <div class="container">
        <div class="row mt-5">
            @include('common.message')
        </div>
        <form action="{{ route('submit-post') }}" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row mt-5">
                <div class="col-md-8">
                    <input type="hidden" class="form-control" name="post_id" value="{{ request()->id }}">
                    <label for="title" class="form-label">Title</label>
                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ $post->title ?? old('title') }}" required autocomplete="title">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-8">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10"
                        class="form-control @error('title') is-invalid @enderror" required autocomplete="description">{{ $post->description ?? old('description') }}</textarea>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="thumbnail" class="form-label">Thumbail</label>
                    <input id="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                        name="thumbnail" accept="image/*" {{ request()->id == '' ? 'required' : '' }}>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
@endsection
@push('js')
    <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
@endpush
