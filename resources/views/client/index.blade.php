@extends('layouts.app')

@section('content')
<div class="container">

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createClientModal">
        Create new client
    </button>
      
      <!-- Modal -->
      <div class="modal fade" id="createClientModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Create Client</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              
            </div>
            <div class="modal-body">
                <div class="ajaxForm">
                    <div class="form-group">
                        <label for="client_name">Client Name</label>
                        <input id="client_name" class="form-control" type="text" name="client_name" />
                    </div>
                    <div class="form-group">
                        <label for="client_surname">Client Surname</label>
                        <input id="client_surname" class="form-control" type="text" name="client_surname" />
                    </div>
                    <div class="form-group">
                        <label for="client_description">Client Description</label>
                        <input id="client_description" class="form-control" type="text" name="client_description" />
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button id="close-client-create-modal" type="button" class="btn btn-secondary">Close with Javascript</button>
              <button id="submit-ajax-form" type="button" class="btn btn-primary">Save changes</button>

            </div>
          </div>
        </div>
      </div>

    <div id="alert" class="alert alert-success d-none">
    </div>    
   


    <table id="clients-table" class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Description</th>
        </tr>
        @foreach ($clients as $client) 
        <tr>
            <td>{{$client->id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->surname}}</td>
            <td>{{$client->description}}</td>
        </tr>
        @endforeach
    </table>
</div>

<script>

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $("#close-client-create-modal").click(function() {
            $("#createClientModal").modal('hide')
        });

        console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let client_name;
            let client_surname;
            let client_description;

            client_name = $('#client_name').val();
            client_surname = $('#client_surname').val();
            client_description = $('#client_description').val();

            // console.log(client_name + " " + client_surname + " "  + client_description);

            $.ajax({
                type: 'POST',// formoje method POST GET
                url: '{{route("client.storeAjax")}}' ,// formoje action
                data: {client_name: client_name, client_surname: client_surname, client_description: client_description  },
                success: function(data) {
                    //data kintamasis ir yra atsakymas
                    //i alerta turetu isivesti atsakymas
                    // $("#alert").html(data);

                    //data kintamasis yra masyvas
                    // data.client_id
                    // data.client_name
                   console.log(data);

                    let html =  "<tr><td>"+data.clientId+"</td><td>"+data.clientName+"</td><td>"+data.clientSurname+"</td><td>"+data.clientDescription+"</td></tr>";
                    $("#clients-table").append(html);

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.clientName +" " +data.clientSurname);

                    
                }
            });

        });
        //1. turi Save mygtuko paspaudimu pasiimti duomenis is input laukeliu
        // 2. kazka turim pasakyti su javascriptu kad siustume nurodyma i serveri
    })
</script>


@endsection