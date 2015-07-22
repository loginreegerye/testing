<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Book;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use Event;
use App\Events\BookIsAdded;
use Carbon\Carbon;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }
    
    public function getAllPaginate()
    {
        $books = Book::orderBy('id', 'desc')->paginate(10);

        return view('book/all', ['books'=>$books]);
    }

    public function getAvailableToAdd()
    {
        $books = Book::all()->where('user_id', 0);

        return view('user/add', ['books' => $books]);
    }

    public function addBookToUser($user_id, $book_id)
    {
        $book = Book::find($book_id);
        $book->user_id = $user_id;
        $book->left_date = Carbon::now()->addDays(30);
        $book->save();

        Session::flash('message', 'BOOK SUCCESSFYLLY ADDED TO USER');
        return Redirect::to('user/'.$user_id);
    }

    public function addUserToBook($book_id, $user_id)
    {
        $book = Book::find($book_id);
        $book->user_id = $user_id;
        $book->left_date = Carbon::now()->addDays(30);
        $book->save();

        Session::flash('message', 'USER SUCCESSFYLLY ADDED FOR BOOK');
        return Redirect::to('book/'.$book_id);
    }

    public function deleteBookFromUser($user_id, $book_id)
    {
        $book = Book::find($book_id);
        $book->user_id = 0;
        $book->left_date = null;
        $book->save();

        Session::flash('message', 'BOOK DELETE FROM USER');
        return Redirect::to('user/'.$user_id);
    }

    public function deleteUserFromBook($book_id, $user_id)
    {
        $book = Book::find($book_id);
        $book->user_id = 0;
        $book->left_date = null;
        $book->save();

        Session::flash('message', 'USER OF THIS BOOK WAS REMOVED');
        return Redirect::to('book/'.$book_id);
    }

    public function index()
    {
      return Redirect::back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('book/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = ['title' => 'required',
                  'author' => 'required|alpha',
                  'year' => 'required|numeric',
                  'genre' => 'required|alpha'];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return Redirect::to('book/create')->withErrors($validator)->withInput();
        } else {
            $book = new Book();
            $book->title = $request->title;
            $book->author = $request->author;
            $book->year = $request->year;
            $book->genre = $request->genre;
            $book->save();

            //Event::fire(new BookIsAdded($book));
            
            Session::flash('message', 'SUCCESSFYLLY CREATED');
            return Redirect::to('book/'.$book->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $user = Book::find($id)->user;

        if(!empty($user)) {
            return view('book/one', ['book' => $book, 'user' => $user]);
        } else {
            $empty = 'THIS BOOK HAS NO USER';
            return view('book/one', ['book' => $book, 'empty' => $empty]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        return view('book/edit', ['book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $rules = ['title' => 'required',
                  'author' => 'required|alpha',
                  'year' => 'required|numeric',
                  'genre' => 'required|alpha'];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return Redirect::to('book/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            $book = Book::find($id);
            $book->title = $request->title;
            $book->author = $request->author;
            $book->year = $request->year;
            $book->genre = $request->genre;
            $book->save();
            
            Session::flash('message', 'SUCCESSFYLLY UPDATED');
            return Redirect::to('book/'.$book->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = Book::find($id)->user;

        if(!empty($user)) {
            Session::flash('message', 'CAN\'T DELETE, BOOK HAS USER');
            return Redirect::to('book/'.$id);
        } else {
            $book = Book::find($id);
            $book->delete();
            Session::flash('message', 'BOOK SUCCESSFYLLY DELETED, BUT YOU CAN CREATE THE NEW BOOK BY USING THIS FORM');
            return Redirect::to('book/create');
        }
    }
}
