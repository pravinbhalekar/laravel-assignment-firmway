<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use File;

class PostController extends Controller
{
    private $uploadFolder = 'assets/thumbnail';
    private $width = 300;
    private $height = 300;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('post.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //validate request 
            $request->validate([
                'title' => 'required|max:256',
                'description' => 'required',
            ]);
            //validate image on add post
            if (!$request->post_id) {
                $request->validate([
                    'thumbnail' => 'required|mimes:jpeg,jpg,png|max:10000',
                ]);
            }
            //Edit Post
            if ($request->post_id) {
                $post = PostModel::find($request->post_id);
                $message = 'Post updated successfully';
                //Delete previous thumbnail
                if ($request->thumbnail) {
                    $oldThumbnail = public_path($post->thumbnail);
                    if (file_exists($oldThumbnail)) {
                        File::delete($oldThumbnail);
                    }
                }
            } else {
                //Add post
                $post = new PostModel();
                $post->user_id = Auth::user()->id;
                $message = 'Post added successfully';
            }
            //create slug
            if ($request->title == $post->title) {
                $slug = $post->slug;
            } else {
                $slug = PostModel::createUniqueSlug($request->title);
            }
            $post->title = $request->title;
            $post->slug = $slug;
            $post->thumbnail = $request->thumbnail ? $this->uploadThumbnail($request) : $post->thumbnail;
            $post->description = $request->description;
            $post->save();
            return redirect(route('dashboard'))->with('success', $message);
        } catch (\Throwable $th) {
            // throw $th;
            return back()->with('error', 'Error in adding post');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  object  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadThumbnail($request)
    {
        try {
            //create image name
            $input['imagename'] = str_replace(' ', '-', strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $request->title))) . '-' . time() . '.' . $request->thumbnail->extension();
            //upload path
            $destinationPath = public_path($this->uploadFolder);
            //create image
            $img = Image::make($request->thumbnail->path());

            //resize image
            $img->resize($this->width, $this->height, function () {
            })->save($destinationPath . '/' . $input['imagename']);

            //return image path
            return $this->uploadFolder . '/' . $input['imagename'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $post = PostModel::find($id);
            if ($post) {
                //check auth user post
                if (Auth()->user()->id != $post->user_id) {
                    return redirect()->back()->with('error', 'Unauthorised access');
                }
                return view('post.index', compact('post'));
            } else {
                return redirect('404');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            //get post details
            $post = PostModel::find($request->post_id);
            if ($post) {
                //check auth user post
                if (Auth()->user()->id != $post->user_id) {
                    return redirect()->back()->with('error', 'Unauthorised access');
                }
                $post->is_published = $post->is_published == "0" ? "1" : "0";
                if ($post->save()) {
                    $message = $post->is_published == "0" ? 'unpublished' : 'published';
                    return back()->with('success', 'Post ' . $message . ' successfully');
                }
            } else {
                return redirect('404');
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //get post details
        $post = PostModel::find($request->post_id);
        if ($post) {
            if ($post->delete()) {
                return redirect()->back()->with('error', 'Post deleted successfully');
            }
        } else {
            return redirect('404');
        }
    }
}
