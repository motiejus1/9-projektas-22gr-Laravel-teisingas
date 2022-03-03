@extends('layouts.app')

@section('content')
<div class="container">


    <div id="alert" class="alert alert-success">
    </div>    

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
            <div class="form-group">
                <button id="submit-ajax-form" class="btn btn-primary"> Save </button>   
            </div>
        </div>    
    
</div>
    {{-- <form> --}}

    {{-- @csrf x --}}
    {{-- veiksmo nurodymas i serveri  --}}

    <script>

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
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
                        $("#alert").html(data);

                    }
                });

            });
            //1. turi Save mygtuko paspaudimu pasiimti duomenis is input laukeliu
            // 2. kazka turim pasakyti su javascriptu kad siustume nurodyma i serveri
        })
    </script>
@endsection