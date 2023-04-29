<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use App\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class postController extends Controller
{
    public function createstore(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'video' => 'mimetypes:video/mp4|max:5048',
            'image.*' => 'image',
        ]);
        $post = new posts();
        $post->title = $request->title;
        $post->body = request('body');
        $post->user_id = auth()->user()->id;
        if ($request->hasFile('image')) {
            $filenamewithext = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extention;
            $request->file('image')->storeAs('public/image', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        }
        if ($request->hasFile('video')) {
            $filenamewithext = $request->file('video')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extention = $request->file('video')->getClientOriginalExtension();
            $fileNameToStorevideo = $filename . '_' . time() . '.' . $extention;
            $request->file('video')->storeAs('public/video', $fileNameToStorevideo);
        } else {
            $fileNameToStorevideo = 'noimage.jpg';
        }
        $post->image = $fileNameToStore;
        $post->video = $fileNameToStorevideo;
        $post->save();
        return redirect()->route('welcome');
    }
    public function postsingle($id)
    {
        $post = posts::find($id);
        return view('single')->with('post', $post);
    }
    public function likes($id)
    {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $like->posts_id = $id;
        $like->save();

        return back();
    }
    public function delete($id, Request $request)
    {
        $request->user()->likes()->where('posts_id', $id)->delete();
        return back();
    }
    public function editshow($id)
    {
        $post = posts::find($id);
        return view('admin.edit')->with([
            'post' => $post
        ]);
    }
    public function edit($id, Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'video' => 'mimetypes:video/mp4|max:5048',
            'image.*' => 'image',
        ]);
        $post = posts::find($id);
        $post->title = request('title');
        $post->body = request('body');
        // dd($request->hasFile('image'));
        if ($request->hasFile('image')) {
            $filenamewithext = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extention = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extention;
            $request->file('image')->storeAs('public/image', $fileNameToStore);

            if ($post->video != 'noimage.jpg') {
                Storage::delete("public/video/$post->video");
                $post->video = 'noimage.jpg';
            }
            Storage::delete("public/image/$post->image");
            $post->image = $fileNameToStore;
        } elseif ($request->hasFile('video')) {
            $filenamewithext = $request->file('video')->getClientOriginalName();
            $filename = pathinfo($filenamewithext, PATHINFO_FILENAME);
            $extention = $request->file('video')->getClientOriginalExtension();
            $fileNameToStorevideo = $filename . '_' . time() . '.' . $extention;
            $request->file('video')->storeAs('public/video', $fileNameToStorevideo);
            if ($post->image != 'noimage.jpg') {
                Storage::delete("public/image/$post->image");
                $post->image = 'noimage.jpg';
            }
            Storage::delete("public/video/$post->video");
            $post->video = $fileNameToStorevideo;
        } else {
            $post->image = $post->image;
            $post->video = $post->video;
        }
        // else {
        //     if ($post->image != 'noimage.jpg' && $post->video == 'noimage.jpg') {

        //         Storage::delete("public/image/$post->image");
        //         $post->image = 'noimage.jpg';
        //         $post->video = $post->video;
        //     }
        // }
        // $post->image = $fileNameToStore;
        // $post->video = $fileNameToStorevideo;
        $post->save();
        return redirect()->route('welcome');
    }
    public function deletepost($id)
    {
        $post = posts::find($id);
        $post->delete();
        if ($post->image != 'noimage.jpg') {
            Storage::delete("public/image/$post->image");
        }
        if ($post->video != 'noimage.jpg') {
            Storage::delete("public/video/$post->video");
        }
        if ($post->comment->count() > 0) {
            foreach ($post->comment as $item) {
                $item->delete();
            }
        }
        return redirect()->route('welcome')->with('success', 'Post Successfully deleted');
    }
    public function blog()
    {
        $posts = posts::paginate('10');
        return view('blog')->with([
            'posts' => $posts
        ]);
    }
    public function comment($id, Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|string|max:255|min:2'
        ]);
        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->posts_id = $id;
        $comment->body = $request->comment;
        $comment->save();
        return back();
    }
}
