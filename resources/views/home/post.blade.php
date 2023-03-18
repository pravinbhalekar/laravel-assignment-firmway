@extends('layouts.app')
@section('title')
    {{ $post->title }}
@endsection

@section('content')
    <div class="container">
        <div class="text-center my-5 p-2"><br>
            <h1>{{ $post->title }}</h1>
            <hr />
        </div>

        <div class="row">

            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="card mb-5 shadow-sm">
                    <img src="{{ asset($post->thumbnail) }}" class="img-fluid" />
                    <div class="card-body">
                        <div class="card-title text-justify">
                            <h4 title="{{ $post->title }}">{{ $post->title }}</h4>
                            <p><b>({{ date('d M, Y', strtotime($post->created_at)) }}) - {{ $post->author->name }}</b></p>
                        </div>
                        <div class="card-text">
                            {!! nl2br($post->description) !!}
                            <p>&nbsp;</p>
                        </div>
                        <p><a href="{{ URL::previous() }}"
                                class="btn btn-outline-primary rounded-0 float-end">Back</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
