@extends('layouts.app')
@section('section')
    <div class="contact">
        <form action="{{ route('edit', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="contact-container">

                <label for="title">Title:</label>
                <input type="text" id="title" value="{{ $post->title }}" name="title"
                    class="@error('title') error @enderror">
                @error('title')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <label for="body">Body:</label>
                <textarea style="resize: none" name="body" id="body" class="@error('body') error @enderror">{{ $post->body }}</textarea>
                @error('body')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <label for="upload">Choose the kind of file you want to upload</label>
                <select name="upload" id="upload">
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                </select>
                <label for="image" id="label-image">Upload Image</label>
                <input type="file" name="image" style="display: none;" id="image"
                    class="@error('image') error @enderror" value="image" multiple>
                <label for="video" id="label-video">Upload Video</label>
                <input type="file" style="display: none;" name="video" id="video"
                    class="@error('video') error @enderror">
                @error('image')
                    <div class="error-text" style="margin-bottom:20px;">{{ $message }}</div>
                @enderror
                @error('video')
                    <div class="error-text" style="margin-bottom:20px;">{{ $message }}</div>
                @enderror
                <button class="btn2">Submit</button>
            </div>
        </form>

    </div>
@section('script')
    const category = document.getElementById("upload");
    const image = document.getElementById("image");
    const labelimage = document.getElementById("label-image");
    const labelvideo = document.getElementById("label-video");
    const video = document.getElementById("video");
    window.addEventListener("DOMContentLoaded", () => {
    if (category.value == "image") {

    image.style.display = 'block';
    labelimage.style.display = 'block';
    } else {
    image.style.display = 'none';
    labelimage.style.display = 'none';
    }

    if (category.value == "video") {
    video.style.display = 'block';
    labelvideo.style.display = 'block';
    } else {
    video.style.display = 'none';
    labelvideo.style.display = 'none';
    }
    });
    category.addEventListener("click", () => {
    if (category.value == "image") {
    image.style.display = 'block';
    labelimage.style.display = 'block';
    } else {
    image.style.display = 'none';
    labelimage.style.display = 'none';
    }
    if (category.value == "video") {
    video.style.display = 'block';
    labelvideo.style.display = 'block';
    } else {
    video.style.display = 'none';
    labelvideo.style.display = 'none';
    }
    });
@endsection
@endsection
