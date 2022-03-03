<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
        $clients = Client::all();
        return view("client.index", ['clients'=>$clients]);
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
    
        $client->save();

        $client_array = array(
            'successMessage' => "Client stored succesfuly",
            'clientId' => $client->id,
            'clientName' => $client->name,
            'clientSurname' => $client->surname,
            'clientDescription' => $client->description,
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
        //
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
    public function update(UpdateClientRequest $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
