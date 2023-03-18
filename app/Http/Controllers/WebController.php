<?php

namespace App\Http\Controllers;

use App\Jobs\QueueJob;
use App\Mail\DailyUpdateMail;
use App\Models\PostModel;
use App\Models\User;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $post = PostModel::where('is_published', '1')->orderby('id', 'desc')->paginate(6);
            return view('home.index', compact('post'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        try {
            $post = PostModel::where('slug', $slug)->with('author')->first();
            if ($post) {
                return view('home.post', compact('post'));
            } else {
                return redirect('404');
            }
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
    public function dailyUpdateEmail()
    {
        try {
            //get email list
            $users = User::select('email')->get();

            //create a new array of email
            $collection = collect($users);
            $plucked  = $collection->pluck('email');
            $emails = $plucked->all();

            // $emails = ['aa@yopmail.com','bb@yopmail.com','cc@yopmail.com'];
            //dispatch
            dispatch(new QueueJob($emails));

            return 'Email send successfully';
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
