@extends('layouts.app')

@section('content')


<div class="container">


    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
      Create Client
    </button>

    <button id="remove-table">Remove table</button>

    <!-- Modal -->
      
      <!-- Modal -->
      

    <div id="alert" class="alert alert-success d-none">
    </div>    
   


    <table id="clients-table" class="table table-striped">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Surname</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        @foreach ($clients as $client) 
        <tr class="client{{$client->id}}">
            <td class="col-client-id">{{$client->id}}</td>
            <td class="col-client-name">{{$client->name}}</td>
            <td class="col-client-surname">{{$client->surname}}</td>
            <td class="col-client-description">{{$client->description}}</td>
            <td>
              {{-- <form action={{route("client.destroy",[$client])}} method="POST"> --}}
              
                <button class="btn btn-danger delete-client" type="submit" data-clientid="{{$client->id}}">DELETE</button>
                <button type="button" class="btn btn-primary show-client" data-bs-toggle="modal" data-bs-target="#showClientModal" data-clientid="{{$client->id}}">Show</button>
                <button type="button" class="btn btn-secondary edit-client" data-bs-toggle="modal" data-bs-target="#editClientModal" data-clientid="{{$client->id}}">Edit</button>
              {{-- </form>   --}}

            </td>
        </tr>
        @endforeach
    </table>

  
    <table class="template">
        <tr>
          <td class="col-client-id"></td>
          <td class="col-client-name"></td>
          <td class="col-client-surname"></td>
          <td class="col-client-description"></td>
          <td>
            <button class="btn btn-danger delete-client" type="submit" data-clientid="">DELETE</button>
            <button type="button" class="btn btn-primary show-client" data-bs-toggle="modal" data-bs-target="#showClientModal" data-clientid="">Show</button>
            <button type="button" class="btn btn-secondary edit-client" data-bs-toggle="modal" data-bs-target="#editClientModal" data-clientid="">Edit</button>
          </td>
        </tr>  
    </table>  

    

    
</div>



<script>

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {

        $("#remove-table").click(function(){
          $('.client55').remove();
        });

        function createRow(clientId, clientName, clientSurname, clientDescription ) {
                    let html
                    html += "<tr class='client"+clientId+"'>";
                    html += "<td>"+clientId+"</td>";    
                    html += "<td>"+clientName+"</td>";  
                    html += "<td>"+clientSurname+"</td>";  
                    html += "<td>"+clientDescription+"</td>";  
                    html += "<td>";
                    html +=  "<button class='btn btn-danger delete-client' type='submit' data-clientid='"+clientId+"'>DELETE</button>"; 
                    html +=  "</td>";
                    html += "</tr>";

                   return html 
        }

        function createRowFromHtml(clientId, clientName, clientSurname, clientDescription) {
          $(".template tr").addClass("client"+clientId);
          $(".template .delete-client").attr('data-clientid', clientId );
          $(".template .show-client").attr('data-clientid', clientId );
          $(".template .edit-client").attr('data-clientid', clientId );
          $(".template .col-client-id").html(clientId );
          $(".template .col-client-name").html(clientName );
          $(".template .col-client-surname").html(clientSurname );
          $(".template .col-client-description").html(clientDescription );
          
          

          // console.log($(".template tbody").html());

          return $(".template tbody").html();
        }

    
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
                    let html;


                    //1 variantas
                    // html += "<tr class='client"+data.clientId+"'>";
                    // html += "<td>"+data.clientId+"</td>";    
                    // html += "<td>"+data.clientName+"</td>";  
                    // html += "<td>"+data.clientSurname+"</td>";  
                    // html += "<td>"+data.clientDescription+"</td>";  
                    // html += "<td>";
                    // html +=  "<button class='btn btn-danger delete-client' type='submit' data-clientid='"+data.clientId+"'>DELETE</button>"; 
                    // html +=  "</td>";
                    // html += "</tr>";


                    // let html = "<tr class='client"+data.clientId+"'><td>"+data.clientId+"</td><td>"+data.clientName+"</td><td>"+data.clientSurname+"</td><td>"+data.clientDescription+"</td><td><button class='btn btn-danger delete-client' type='submit' data-clientid='"+data.clientId+"'>DELETE</button><button type='button' class='btn btn-primary show-client' data-bs-toggle='modal' data-bs-target='#showClientModal' data-clientid='"+data.clientId+"'>Show</button><button type='button' class='btn btn-secondary edit-client' data-bs-toggle='modal' data-bs-target='#editClientModal' data-clientid='"+data.clientId+"'>Edit</button></td></tr>";
                    
                    // html = createRow(data.clientId, data.clientName, data.clientSurname, data.clientDescription);
                    html = createRowFromHtml(data.clientId, data.clientName, data.clientSurname, data.clientDescription);
                    $("#clients-table").append(html);

                    $("#createClientModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.clientName +" " +data.clientSurname);

                    $('#client_name').val('');
                    $('#client_surname').val('');
                    $('#client_description').val('');

                    
                }
            });

        });
        //1. turi Save mygtuko paspaudimu pasiimti duomenis is input laukeliu
        // 2. kazka turim pasakyti su javascriptu kad siustume nurodyma i serveri



        //click ji sugeba dirbti tiktai su isanksto sugeneruotais html elementais
        // $(".delete-client").click(function(){
          $(document).on('click', '.delete-client', function() {
            let clientid;
            clientid = $(this).attr('data-clientid');
            console.log(clientid);

            $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/clients/deleteAjax/' + clientid  ,// formoje action
                success: function(data) {
                   console.log(data);

                   $('.client'+clientid).remove();
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);                    
                }
            });

        });

        $(document).on('click', '.show-client', function() {
            let clientid;
            clientid = $(this).attr('data-clientid');
            console.log(clientid);

            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/clients/showAjax/' + clientid  ,// formoje action
                success: function(data) {
                   $('.show-client-id').html(data.clientId);                   
                   $('.show-client-name').html(data.clientName);                   
                   $('.show-client-surname').html(data.clientSurname);                   
                   $('.show-client-description').html(data.clientDescription);                                  
                }
            });

        });

        $(document).on('click', '.edit-client', function() {
          let clientid;
            clientid = $(this).attr('data-clientid');
            console.log(clientid);

            $.ajax({
                type: 'GET',// formoje method POST GET
                url: '/clients/showAjax/' + clientid  ,// formoje action
                success: function(data) {
                  $('#edit_client_id').val(data.clientId);                   
                   $('#edit_client_name').val(data.clientName);                   
                   $('#edit_client_surname').val(data.clientSurname);                   
                   $('#edit_client_description').val(data.clientDescription);                                  
                }
            });

        });
        $(document).on('click', '.update-client', function() {
          let clientid;
          let client_name;
            let client_surname;
            let client_description;

          clientid = $('#edit_client_id').val();
          client_name = $('#edit_client_name').val();
          client_surname = $('#edit_client_surname').val();
          client_description = $('#edit_client_description').val();
          $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/clients/updateAjax/' + clientid  ,// formoje action
                data: {client_name: client_name, client_surname: client_surname, client_description: client_description  },
                success: function(data) {
                  //  $('.show-client-id').html(data.clientId);

                  // $(".client"+clientid+ " " + ".col-client-id").html(data.clientId)
                  $(".client"+clientid+ " " + ".col-client-name").html(data.clientName)
                  $(".client"+clientid+ " " + ".col-client-surname").html(data.clientSurname)
                  $(".client"+clientid+ " " + ".col-client-description").html(data.clientDescription)
                  
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);
                    
                    $("#editClientModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                }
            });
        })

    })
</script>


@endsection