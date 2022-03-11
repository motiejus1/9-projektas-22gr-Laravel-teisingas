<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Company;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;

use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //sort ir direction
        $clients = Client::sortable()->get();
        $companies = Company::all();

        return view("client.index", ['clients'=>$clients, 'companies'=>$companies]);
    }

    public function indexAjax() {

        //1milijonas
        $clients = Client::with('clientCompany')->sortable()->get();

        //foreach $clients
        //clientTitle
        //$client->clientCompany->title;

        $cliens_array = array(
            'clients' => $clients
        );

        $json_response =response()->json($cliens_array); 

        return $json_response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("client.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = new Client;
        $client->name = $request->client_name;
        $client->surname = $request->client_surname;
        $client->description = $request->client_description;
    
        $client->save();

        return redirect()->route('client.create');
    }

    public function storeAjax(Request $request) {

        $client = new Client;
        $client->name = $request->client_name;
        $client->surname = $request->client_surname;
        $client->description = $request->client_description;
        $client->company_id = $request->client_company_id;
    
        $client->save();//po isaugojimo momento

        $client_array = array(
            'successMessage' => "Client stored succesfuly",
            'clientId' => $client->id,
            'clientName' => $client->name,
            'clientSurname' => $client->surname,
            'clientDescription' => $client->description,
            'clientCompanyId' => $client->company_id,
            'clientCompanyTitle' => $client->clientCompany->title
        );

        // 
        $json_response =response()->json($client_array); //javascript masyva

        // $html = "<tr><td>".$client->id."</td><td>".$client->name."</td><td>".$client->surname."</td><td>".$client->description."</td></tr>";
        //kazkoki tai atsakyma
        //  return $html;

        //json masyvas/ objektu / javascrip asociatyvus masyvas
        //php masyva => json masyva
        // json masyva => php masyva
        return $json_response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return view("client.show", ['client' => $client]);
    }

    public function showAjax(Client $client) {
        $client_array = array(
            'successMessage' => "Client retrieved succesfuly",
            'clientId' => $client->id,
            'clientName' => $client->name,
            'clientSurname' => $client->surname,
            'clientDescription' => $client->description,
            'clientCompanyId' => $client->company_id,
            'clientCompanyTitle' => $client->clientCompany->title

        );

        $json_response =response()->json($client_array); 

        return $json_response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    public function updateAjax(Request $request, Client $client)
    {
        $client->name = $request->client_name;
        $client->surname = $request->client_surname;
        $client->description = $request->client_description;
        $client->company_id = $request->client_company_id;

        $client->save();

        $client_array = array(
            'successMessage' => "Client updated succesfuly",
            'clientId' => $client->id,
            'clientName' => $client->name,
            'clientSurname' => $client->surname,
            'clientDescription' => $client->description,
            'clientCompanyId' => $client->company_id,
            'clientCompanyTitle' => $client->clientCompany->title
        );

        // 
        $json_response =response()->json($client_array); //javascript masyva

        return $json_response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route("client.index");
    }

    public function destroyAjax(Client $client)
    {
        $client->delete();

        $success_array = array(
            'successMessage' => "Client deleted successfuly". $client->id,
        );

        // 
        $json_response =response()->json($success_array);

        return $json_response;
    }
}
