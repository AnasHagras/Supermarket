<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        return view('user.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where([
            ['position', '<>', 'delivery'],
        ])->get();
        return view('user.create', ['employees' => $employees]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {

        $validator = $request->validated();
        if (!empty($validator->errors))
            return back()->withErrors($validator)->withInput();

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isAdmin' => $request->isAdmin,
            'employeeID' => $request->employeeID
        ]);
        return redirect()->route('user.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('userID', $id)->first();
        return view('user.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::where('userID', $id)->first();
        $employees = Employee::where([
            ['position', '<>', 'delivery'],
        ])->get();
        return view('user.edit', ['data' => $data, 'employees' => $employees]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $validator = $request->validated();
        if (!empty($validator->errors))
            return back()->withErrors($validator)->withInput();

        $user = User::where('userID', $id)->first();

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'isAdmin' => $request->isAdmin,
            'employeeID' => $request->employeeID
        ]);
        return redirect()->route('user.index')->with('msg', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('userID', $id)->first();
        $user->delete();
        return redirect()->route('user.index')->with('msg', 'Deleted successfully');
    }
}
