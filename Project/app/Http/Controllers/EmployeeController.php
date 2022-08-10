<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
        return view("employee.index", ["data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {

        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        // if ($validator->fails()) {

        // }
        Employee::create([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'position' => $request->position,
            'salary' => $request->salary,
        ]);
        return redirect()->route('employee.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Employee::where('employeeID', $id)->first();;
        return view('employee.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = Employee::where('employeeID', $id)->first();
        return view('employee.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {

        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }

        $employee = Employee::where('employeeID', $id)->first();
        $employee->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'position' => $request->position,
            'salary' => $request->salary,
        ]);
        return redirect()->route('employee.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('employeeID', $id);
        $employee->delete();
        return redirect()->route('employee.index')->with('msg', 'deleted successfully');
    }
}
