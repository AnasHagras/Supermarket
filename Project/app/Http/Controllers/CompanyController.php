<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        // Middleware only applied to these methods
        $this->middleware('access', [
            'only' => [
                'update',
                'store',
                'edit',
                'destroy'
            ]
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Company::all();
        return view('company.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        Company::create([
            'companyName' => $request->companyName,
            'companyEmail' => $request->companyEmail
        ]);
        return redirect()->route('company.index')->with('msg', 'added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Company::where('companyID', $id)->first();
        return view('company.show', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Company::where('companyID', $id)->first();
        return view('company.edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $validator = $request->validated();
        if (!empty($validator->errors)) {
            return back()->withErrors($validator)->withInput();
        }
        $company = Company::where('companyID', $id)->first();
        $company->update([
            'companyName' => $request->companyName,
            'companyEmail' => $request->companyEmail
        ]);
        return redirect()->route('company.index')->with('msg', 'updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::where('companyID', $id);
        $company->delete();
        return redirect()->route('company.index')->with('msg', 'deleted successfully');
    }
}
