@extends('layouts.app')

@section('content')

<style>
th div {
  cursor: pointer;
}

</style>  
<div class="container">
 

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
      Create Client
    </button>

    <input id="hidden-sort" type="hidden" value="id" />
    <input id="hidden-direction" type="hidden" value="asc" />

    <div id="alert" class="alert alert-success d-none">
    </div>    
   
    {{-- paieska --}}
    <div class="searchAjaxForm">
    <input id="searchValue" type="text">
    <span class="search-feedback"></span>
    {{-- <button type="button" id="submitSearch">Find</button> --}}
    </div>  

    <table id="clients-table" class="table table-striped">
      <thead>
        <tr>
          <th><div class="clients-sort" data-sort="id" data-direction="asc">ID</div></th>
          <th><div class="clients-sort"  data-sort="name" data-direction="asc">Name</div></th>
          <th><div class="clients-sort"  data-sort="surname" data-direction="asc">Surname</div></th>
          <th><div class="clients-sort" data-sort="description" data-direction="asc">Description</div></th>
          <th><div class="clients-sort"  data-sort="clientCompany.title" data-direction="asc">Company</div></th>
          <th>Actions</th>
      </tr>
      </thead>
      <tbody>
        @foreach ($clients as $client) 
        <tr class="client{{$client->id}}">
            <td class="col-client-id">{{$client->id}}</td>
            <td class="col-client-name">{{$client->name}}</td>
            <td class="col-client-surname">{{$client->surname}}</td>
            <td class="col-client-description">{{$client->description}}</td>
            <td class="col-client-company">{{$client->clientCompany->title}}</td>
            <td>
              {{-- <form action={{route("client.destroy",[$client])}} method="POST"> --}}
              
                <button class="btn btn-danger delete-client" type="submit" data-clientid="{{$client->id}}">DELETE</button>
                <button type="button" class="btn btn-primary show-client" data-bs-toggle="modal" data-bs-target="#showClientModal" data-clientid="{{$client->id}}">Show</button>
                <button type="button" class="btn btn-secondary edit-client" data-bs-toggle="modal" data-bs-target="#editClientModal" data-clientid="{{$client->id}}">Edit</button>
              {{-- </form>   --}}

            </td>
        </tr>
        @endforeach
      </tbody>   
        
       
    </table>

  
    <table class="template d-none">
        <tr>
          <td class="col-client-id"></td>
          <td class="col-client-name"></td>
          <td class="col-client-surname"></td>
          <td class="col-client-description"></td>
          <td class="col-client-company"></td>
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

        function createRowFromHtml(clientId, clientName, clientSurname, clientDescription, clientCompanyId) {
          $(".template tr").removeAttr("class");
          $(".template tr").addClass("client"+clientId);
          $(".template .delete-client").attr('data-clientid', clientId );
          $(".template .show-client").attr('data-clientid', clientId );
          $(".template .edit-client").attr('data-clientid', clientId );
          $(".template .col-client-id").html(clientId );
          $(".template .col-client-name").html(clientName );
          $(".template .col-client-surname").html(clientSurname );
          $(".template .col-client-description").html(clientDescription );
          $(".template .col-client-company").html( clientCompanyId);
    
          return $(".template tbody").html();
        }

    
        console.log("Jquery veikia");
        $("#submit-ajax-form").click(function() {
            let client_name;
            let client_surname;
            let client_description;
            let client_company_id;
            let sort;
            let direction;

            client_name = $('#client_name').val();
            client_surname = $('#client_surname').val();
            client_description = $('#client_description').val();
            client_company_id = $('#client_company_id').val();
            sort = $('#hidden-sort').val();
            direction = $('#hidden-direction').val();

            $.ajax({
                type: 'POST',// formoje method POST GET
                url: '{{route("client.storeAjax")}}' ,// formoje action
                data: {client_name: client_name, client_surname: client_surname, client_description: client_description, client_company_id: client_company_id, sort:sort, direction:direction  },
                success: function(data) {
                    console.log(data);
                    
                    if($.isEmptyObject(data.errorMessage)) {
                      //sekmes atvejis
                      $("#clients-table tbody").html('');
                     $.each(data.clients, function(key, client) {
                          let html;
                          html = createRowFromHtml(client.id, client.name, client.surname, client.description, client.client_company.title);
                          // console.log(html)
                          $("#clients-table tbody").append(html);
                     });

                    $("#createClientModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage +" " + data.clientName +" " +data.clientSurname);

                    $('#client_name').val('');
                    $('#client_surname').val('');
                    $('#client_description').val('');
                    } else {
                      console.log(data.errorMessage);
                      console.log(data.errors);
                      $('.create-input').removeClass('is-invalid');
                      $('.invalid-feedback').html('');

                      $.each(data.errors, function(key, error) {
                        console.log(key);//key = input id
                        $('#'+key).addClass('is-invalid');
                        $('.input_'+key).html("<strong>"+error+"</strong>");
                      });
                    }
                    
                    //prideda i lenteles pabaiga nauja irasa. Ji mums perbraizys visa lentele pagal tai kaip viskas isrikiuota
                    //clients - pakeisti controlleri
                    
                    

                    
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
                   $('.show-client-company').html(data.clientCompanyTitle);                                  
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
                   
                   $('#edit_client_company_id option').removeAttr('selected');
                   $('#edit_client_company_id').val(data.clientCompanyId);
                   $('#edit_client_company_id .company'+ data.clientCompanyId).attr("selected", "selected");                                 
                }
            });

        });
        $(document).on('click', '.update-client', function() {
          let clientid;
          let client_name;
            let client_surname;
            let client_description;
            let client_company_id;


          clientid = $('#edit_client_id').val();
          client_name = $('#edit_client_name').val();
          client_surname = $('#edit_client_surname').val();
          client_description = $('#edit_client_description').val();
          client_company_id = $('#edit_client_company_id').val();
          $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/clients/updateAjax/' + clientid  ,// formoje action
                data: {client_name: client_name, client_surname: client_surname, client_description: client_description, client_company_id: client_company_id  },
                success: function(data) {
                  //  $('.show-client-id').html(data.clientId);

                  // $(".client"+clientid+ " " + ".col-client-id").html(data.clientId)
                  $(".client"+clientid+ " " + ".col-client-name").html(data.clientName);
                  $(".client"+clientid+ " " + ".col-client-surname").html(data.clientSurname);
                  $(".client"+clientid+ " " + ".col-client-description").html(data.clientDescription);
                  $(".client"+clientid+ " " + ".col-client-company").html(data.clientCompanyTitle);
                  
                    $("#alert").removeClass("d-none");
                    $("#alert").html(data.successMessage);
                    
                    $("#editClientModal").hide();
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('body').css({overflow:'auto'});

                }
            });
        });

        $('.clients-sort').click(function() {
          let sort;
          let direction;

          sort = $(this).attr('data-sort');
          direction = $(this).attr('data-direction');

          $("#hidden-sort").val(sort);
          $("#hidden-direction").val(direction);

          if(direction == 'asc') {
            $(this).attr('data-direction', 'desc');
          } else {
            $(this).attr('data-direction', 'asc');
          }


          $.ajax({
                type: 'GET',// formoje method POST GET
                url: '{{route("client.indexAjax")}}'  ,// formoje action
                data: {sort: sort, direction: direction },
                success: function(data) {
                  // data
                  console.log(data.clients);
                  //perbraizysiu lentele
                    //ciklo kuris pereina per visa masyva
                    //kiekvienos ciklo iteracijos metu mes tiesiog turime klienta prikabinti prie tbody tago
                    // foreach $clients as $client
                    $("#clients-table tbody").html('');
                     $.each(data.clients, function(key, client) {
                      //  $client->clientCompany->title
                          let html;
                          html = createRowFromHtml(client.id, client.name, client.surname, client.description, client.client_company.title);
                          // console.log(html)
                          $("#clients-table tbody").append(html);
                     });


                  //mygtuku rikiavimui

                }
            });
        });

        // $('#submitSearch').click(function() {
          $(document).on('input', '#searchValue', function() {
          //input Search value turiu pasiimti reiksme
          let searchValue = $('#searchValue').val();
          //paieskos reiksme negali buti tuscia ir trumpesne nei 3 simboliai
          let searchFieldCount= searchValue.length;

          if(searchFieldCount == 0) {
            console.log("Field is empty");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Field is empty");
          } else if (searchFieldCount != 0 && searchFieldCount< 3 ) {
            console.log("Min 3");
            $(".search-feedback").css('display', 'block');
            $(".search-feedback").html("Min 3");
          } else {
            $(".search-feedback").css('display', 'none');
          console.log(searchFieldCount);

          console.log(searchValue);

          $.ajax({
                type: 'GET',
                url: '{{route("client.searchAjax")}}'  ,
                data: {searchValue: searchValue},
                success: function(data) {


                  if($.isEmptyObject(data.errorMessage)) {
                    //sekmes atvejis
                    $("#clients-table").show();
                    $("#alert").addClass("d-none");
                    $("#clients-table tbody").html('');
                     $.each(data.clients, function(key, client) {
                      //  $client->clientCompany->title
                          let html;
                          html = createRowFromHtml(client.id, client.name, client.surname, client.description, client.company_id);
                          // console.log(html)
                          $("#clients-table tbody").append(html);
                     });                             
                  } else {
                        $("#clients-table").hide();
                        $('#alert').removeClass('alert-success');
                        $('#alert').addClass('alert-danger');
                        $("#alert").removeClass("d-none");
                        $("#alert").html(data.errorMessage); 
                  }                            
                }
            });
          }

        });
    })
</script>


@endsection