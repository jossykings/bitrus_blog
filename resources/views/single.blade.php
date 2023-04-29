@extends('layouts.app')
@section('section')
    <div class="container top" style="margin-top: 40px;">
        <div style="display: flex;justify-content:right;">
            <p>Likes:
                {{ $post->likes->count() }}

            </p>
        </div>
        <a href="{{ url()->previous() }}" class="btn2">
            << back</a>
                <center>
                    <h3 style="margin-top: 40px;">Title:{{ ucfirst($post->title) }}</h3>
                </center>
                @if ($post->video == 'noimage.jpg' && $post->image == 'noimage.jpg')
                    <div class="post-image">
                        ...
                    </div>
                @endif
                @if ($post->video != 'noimage.jpg')
                    <div class="single-video">
                        <video controls>
                            <source src="{{ asset('storage/video/' . $post->video) }}" type="video/mp4">
                        </video>
                    </div>
                @endif
                @if ($post->image != 'noimage.jpg')
                    <div class="singleimagecontainer">

                        <div class="single-image">
                            <img src="{{ asset('storage/image/' . $post->image) }}" alt="post-image">
                        </div>
                    </div>
                @endif
                <div style="display: flex;justify-content:space-between;align-items:center;">
                    <div>
                        @auth

                            @if ($post->likedby(auth()->user()))
                                <form action='{{ route('deletelike', $post->id) }}' method='post'>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn like-btn"><img src="{{ asset('images/heart2.png') }}"
                                            alt="like image"></button>
                                </form>
                            @else
                                <form action='{{ route('like', $post->id) }}' method='post'>
                                    @csrf
                                    <button type="submit" class="btn like-btn"><img src="{{ asset('images/heart.png') }}"
                                            alt="like image"></button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="for-image">

                        @if ($post->image != 'noimage.jpg')
                            <a style="margin-top: 10px;" download href="{{ asset('storage/image/' . $post->image) }}">
                                <img class="btn" src="{{ asset('images/cloud.png') }}" alt="download"> </a>
                        @endif
                        @if ($post->video != 'noimage.jpg')
                            <a style="margin-top: 10px;" download href="{{ asset('storage/video/' . $post->video) }}">
                                <img class="btn" src="{{ asset('images/cloud.png') }}" alt="download"> </a>
                        @endif
                    </div>
                </div>
                {{-- @else
                    <div class="single-image">
                        <img src="{{ asset("storage/$post->image") }}" width='200px' alt="post-image">
                    </div>
                @endif --}}
                <h3 style="margin: 30px 0px;">body:</h3>
                <p class="post-body-single">{{ $post->body }}</p>
                <div class="time-container">

                    <p style="margin-top: 10px; color:gold;"> Written:
                        {{ $post->created_at->diffForHumans() }}</p>
                    @if ($post->created_at != $post->updated_at)
                        <p style="margin-top: 10px; color:gold;"> updated:
                            {{ $post->updated_at->diffForHumans() }}</p>
                    @endif
                </div>
                @auth

                    @admin
                        <div class="btn-container">
                            <div class="first-btn">
                                <a href="{{ route('editshow', $post->id) }}" class="btn">edit</a>
                            </div>
                            <div class="second-btn">
                                <form id="deletepostform" action="{{ route('deletepost', $post->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" id="delete-post">delete</button>
                                </form>
                            </div>
                        </div>
                    @endadmin
                @endauth
                <div style="margin-top: 20px;">
                    <center>
                        <h2>Comments</h2>
                    </center>
                    <div class="comment-body">
                        @foreach ($post->comment as $item)
                            <div>
                                <p>

                                    {{ $item->body }}
                                </p>
                                <small>By: {{ $item->user->name }}</small>
                            </div>
                        @endforeach
                    </div>
                    @guest
                        <div style="display:flex;justify-content:center; margin:20px;">

                            <p>please <a href="{{ route('login') }}" class="btn2">login</a> to be able to comment </p>
                        </div>
                    @endguest

                    @auth

                        <div class="contact-blog">
                            <form action="{{ route('comment', $post->id) }}" method="POST">
                                @csrf
                                <div class="contact-container">
                                    <label for="body">Comment:</label>
                                    <textarea style="resize: none" name="comment" id="comment" class="@error('comment') error @enderror"></textarea>
                                    @error('comment')
                                        <div class="error-text">{{ $message }}</div>
                                    @enderror
                                    <div class="comment-btn">
                                        <button class="btn">comment</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    @endauth


                </div>
    </div>
@endsection
