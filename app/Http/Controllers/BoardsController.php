<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Board;

class BoardsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('own')->only(['update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $page = $request->page;
        $msgs = Board::orderBy('created_at', 'desc')->paginate(10);
        return view('bbs.index')->with('msgs', $msgs)->with('page', $page);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bbs.write_form');
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
        $user = Auth::user();

        Board::create(['title'=>$request->title, 'content'=>$request->content, 'user_id'=>$user->id]);

        return redirect(route('boards.index', ['page'=>1]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $page = $request->page;
        $board = Board::find($id);
        $board->hits++;
        $board->save();

        return view('bbs.show')->with('board', $board)->with('page', $page);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $page = $request->page;
        $b = Board::find($id);
        return view('bbs.edit')->with('board', $b)->with('page', $page);
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
        $this->validate($request, [
            'title'=>'required',
            'content'=>'required'
        ]);
        $b = Board::find($id);
        $b->title=$request->title;
        $b->content= $request->content;
        $b->save();

        return redirect(route('boards.index', ['page'=>$request->page]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $b = Board::find($id);
        $b->delete();

        return redirect(route('boards.index'));
    }

    public function myArticles(Request $request) {
        $msgs = Board::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);

        return view('bbs.index')->with('msgs', $msgs)->with('page', $request->page);
    }
}
