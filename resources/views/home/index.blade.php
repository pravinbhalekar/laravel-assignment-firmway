@extends('layouts.app')
@section('title')
    Home
@endsection

@section('content')
    <div class="container">
        <div class="text-center my-5 p-2"><br>
            <h1>Blog</h1>
            <hr />
        </div>

        <div class="row">
            @foreach ($post as $rows)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card mb-5 shadow-sm">
                        <img src="{{ asset($rows->thumbnail) }}" class="img-fluid" />
                        <div class="card-body">
                            <div class="card-title">
                                <h4 title="{{ $rows->title }}"><a
                                        href="{{ route('view-post', $rows->slug) }}">{{ Str::limit($rows->title, 45) }}</a>
                                </h4>
                            </div>
                            <div class="card-text">
                                <p>
                                    {{ Str::limit($rows->description, 120) }}
                                </p>
                            </div>
                            <p><a href="{{ route('view-post', $rows->slug) }}"
                                    class="btn btn-outline-primary rounded-0 float-end">Read More</a></p>
                            <p><b>({{ date('d M, Y', strtotime($rows->created_at)) }})</b></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {!! $post->links() !!}
    </div>
@endsection
@push('css')
 
@endpush
