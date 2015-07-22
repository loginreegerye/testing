<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user', ['except' => ['show', 'update', 'edit']]);
    }
    
    public function getAllPaginate()
    {
        $users = User::orderBy('id', 'desc')->paginate(10);

        return view('user/all', ['users'=>$users]);
    }

    public function getAllToAdd()
    {
        return view('book/add', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = ['name' => 'required|alpha', 'surname' => 'required|alpha', 'email'=> 'required|email|unique:users', 'password' => 'required|confirmed|min:6', 'role' => 'required'];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return Redirect::to('user/create')->withErrors($validator)->withInput();
        } else {
            $user = new User();
            $user->first_name = $request->name;
            $user->last_name = $request->surname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            Session::flash('message', 'SUCCESSFYLLY CREATED');
            return Redirect::to('user/'.$user->id);
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
        if ((\Auth::user()->role === 'user') && (\Auth::user()->id != $id)) return redirect()->back();

        $user = User::find($id);
        $books = User::find($id)->books;

        if(!$books->isEmpty()) {
            return view('user/one', ['user' => $user, 'books' => $books]);
        } else {
            $empty = 'THIS USER HAS NO BOOKS';
            return view('user/one', ['user' => $user, 'empty' => $empty]);
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
        if ((\Auth::user()->role === 'user') && (\Auth::user()->id != $id)) return redirect()->back();

        $user = User::find($id);

        return view('user/edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ((\Auth::user()->role === 'user') && (\Auth::user()->id != $id)) return redirect()->back();

        $rules = ['first_name' => 'required|alpha', 'last_name' => 'required|alpha', 'email'=> 'required|email'];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return Redirect::to('user/'.$id.'/edit')->withErrors($validator)->withInput();
        } else {
            $user = User::find($id);
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();

            Session::flash('message', 'SUCCESSFYLLY UPDATED');
            return Redirect::to('user/'.$user->id);
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
        $books = User::find($id)->books;

        if(!$books->isEmpty()) {
            Session::flash('message', 'CAN\'T DELETE, USER HAS BOOK DUTY');
            return Redirect::to('user/'.$id);
        } else {
            $user = User::find($id);
            $user->delete();
            Session::flash('message', 'USER SUCCESSFYLLY DELETED, BUT YOU CAN CREATE THE NEW USER BY USING THIS FORM');
            return Redirect::to('user/create');
        }
    }
}
