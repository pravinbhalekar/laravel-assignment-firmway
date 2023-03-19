<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
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
    public function sortArray()
    {
        try {
            //array input
            $input = [0, 1, 1, 0, 1, 2, 1, 2, 0, 0, 0, 1];
            //call sort array function
            return $this->sortArrayByAsc($input);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    /**
     * @purpose : sort array by asc order
     */
    public function sortArrayByAsc($array = [])
    {
        try {
            $collection = collect($array);
            $sorted = $collection->sort();
            $result = $sorted->values()->all();
            return json_encode($result);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function countPairs()
    {
        try {
            $arr = [1, 2, 5, 10, 5];
            $L = 2;
            $R = 15;

            //count
            $count = 0;

            for ($i = 0; $i < count($arr); $i++) {
                //
                for ($j = $i + 1; $j < count($arr); $j++) {
                    // condition
                    if ($arr[$i] * $arr[$j] >= $L && $arr[$i] * $arr[$j] <= $R) {
                        $count++;
                    }
                }
            }
            return $count;
        } catch (\Throwable $th) {
            throw $th;
        }
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
