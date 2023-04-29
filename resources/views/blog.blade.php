@extends('layouts.app')
@section('section')
    <div>
        <div style="margin-top: 40px;  color: #eebc1d;">
            <h1>
                <center>
                    All Posts
                </center>
            </h1>

        </div>
        <div class="card-container">
            @if (count($posts) > 0)
                @foreach ($posts as $item)
                    <div class="card">
                        <center>
                            <h3>Title: <b>{{ ucfirst($item->title) }}</b></h3>
                        </center>
                        @if ($item->image != 'noimage.jpg')
                            <div class="image">
                                <img src="{{ asset('storage/image/' . $item->image) }}" alt="post-image">
                            </div>
                        @endif
                        @if ($item->video != 'noimage.jpg')
                            <div class="image">
                                <video controls>
                                    <source src="{{ asset('storage/video/' . $item->video) }}" type="video/mp4">
                                </video>
                            </div>
                        @endif
                        @if ($item->video == 'noimage.jpg' && $item->image == 'noimage.jpg')
                            <div class="image">
                                <img src="{{ asset('images/noimage.jpg') }}" alt="post-image">
                            </div>
                        @endif

                        <div class="post-body">
                            <div class="date">
                                <div style="margin-bottom:10px; ">
                                    Date:{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</div>
                                <div class="for-image">
                                    @if ($item->image != 'noimage.jpg')
                                        <a style="margin-top: 10px;" download
                                            href="{{ asset('storage/image/' . $item->image) }}">
                                            <img class="btn" src="{{ asset('images/cloud.png') }}" alt="download"> </a>
                                    @endif
                                    @if ($item->video != 'noimage.jpg')
                                        <a style="margin-top: 10px;" download
                                            href="{{ asset('storage/video/' . $item->video) }}">
                                            <img class="btn" src="{{ asset('images/cloud.png') }}" alt="download"> </a>
                                    @endif
                                </div>
                            </div>
                            <div class="body-text">

                                <p>
                                    {{ substr($item->body, 0, 70) }}{{ strlen($item->body) > 70 ? '....' : '' }}
                                </p>
                            </div>
                        </div>
                        <div class="post-btn">
                            <div>
                                <a class="btn" style="margin-top: 10px;"
                                    href="{{ route('showsinglepost', $item->id) }}">Read more</a>
                            </div>
                            <div>
                                @auth

                                    @if ($item->likedby(auth()->user()))
                                        <form action='{{ route('deletelike', $item->id) }}' method='post'>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn like-btn"><img
                                                    src="{{ asset('images/heart2.png') }}" alt="like image"></button>
                                        </form>
                                    @else
                                        <form action='{{ route('like', $item->id) }}' method='post'>
                                            @csrf
                                            <button type="submit" class="btn like-btn"><img
                                                    src="{{ asset('images/heart.png') }}" alt="like image"></button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </div>
                        <div class="likes">
                            <p>
                                Likes {{ $item->likes->count() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>
                    <center>
                        Nothing Posted Yet
                        @auth

                            @admin
                                click <a href="{{ route('create') }}">here</a> to add a post
                            @endadmin
                        @endauth
                    </center>
                </p>
            @endif
        </div>
        <div class="pagination-container">

            {{ $posts->links() }}
        </div>
    </div>
@endsection
