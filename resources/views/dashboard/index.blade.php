@extends('layouts.app')
@section('title')
    Dashboard
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row mt-5">
            @include('common.message')
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Thumbail</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Edit</th>
                            <th scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($post as $key => $rows)
                            <tr>
                                <td><img src="{{ asset($rows->thumbnail) }}" class="img-thumbnail" style="height: 50px;">
                                </td>
                                <td>{{ $rows->title }}</td>
                                <td>{{ Str::limit($rows->description, 200) }}</td>
                                <td>
                                    <button data-id="{{ $rows->id }}"
                                        class="btn publish btn-xs {{ $rows->is_published == 0 ? ' btn-danger' : ' btn-primary' }}">{{ $rows->is_published == 0 ? 'Not Published' : 'Published' }}</button>
                                </td>
                                <td class="text-center"><a title="Edit" href="{{ route('edit-post', $rows->id) }}"><i
                                            class="fa fa-edit fa-2x"></i></a></td>
                                <td class="text-center"><a href="javascript:void(0)" data-id="{{ $rows->id }}"
                                        class="delete"><i class="fa fa-trash-o fa-2x"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="">
                    {!! $post->links() !!}
                </div>

                <!-- Publish Modal -->
                <div class="modal fade" id="publishModal" tabindex="-1" role="dialog" aria-labelledby="publishModalLabel"
                    aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="publishModalLabel">Publish</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('publish-post') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <h5>Are you want to publish this post?</h5>
                                    <input type="hidden" name="post_id" id="post_id">
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- Delete Modal --}}
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                    aria-hidden="true" data-backdrop="static">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('delete-post') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <h5>Are you want to delete this post?</h5>
                                    <input type="hidden" name="post_id" id="delete_post_id">
                                    <br>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Yes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        button.btn.btn-xs {
            font-size: 12px;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush
@push('js')
    <script src="{{ asset('assets/js/post.js') }}"></script>
@endpush
