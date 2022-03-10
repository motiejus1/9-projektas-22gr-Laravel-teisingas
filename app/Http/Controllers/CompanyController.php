<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return view("company.index", ['companies'=> $companies ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $companies = Company::all();
        return view("company.create", ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new Company;
        $company->title = $request->company_title;
        $company->description = $request->company_description;

        $company->save();

        return redirect()->route('company.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCompanyRequest  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }

    public function destroyAjax(Company $company) {
         // ar kompanija neturi klientu?
        //neturi klientu, kompanija istrinima, generuojamas sekmes pranesimas
        //turi klientu, neleisti kompanijos bandyti istrinti, ir istikro isvesti klaidos(errorMessage) pranesima

        $clients_count = count($company->companyClients);
        
        if($clients_count > 0) {
            $response_array = array(
                'errorMessage' => "Company cannot be deleted because it has clients". $company->id,
            );  
        } else {
            $company->delete();
            $response_array = array(
                'successMessage' => "Company deleted successfuly". $company->id,
            );
        }
 
        $json_response =response()->json($response_array);

        return $json_response;
    }
}
