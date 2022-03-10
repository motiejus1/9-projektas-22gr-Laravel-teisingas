@extends('layouts.app')

@section('content')
<div class="container">
    <div id="alert" class="alert d-none">
    </div>    
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        @foreach ($companies as $company)
        <tr class="company{{$company->id}}">
            <td>{{$company->id}}</td>
            <td>{{$company->title}}</td>
            <td>{{$company->description}}</td>
            <td>
                <button class="btn btn-danger delete-company" type="submit" data-companyid="{{$company->id}}">DELETE</button>
            </td>
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
        $(document).on('click', '.delete-company', function() {
            let companyid;
            companyid = $(this).attr('data-companyid');
            console.log(companyid);

            $.ajax({
                type: 'POST',// formoje method POST GET
                url: '/companies/deleteAjax/' + companyid  ,// formoje action
                success: function(data) {
                   console.log(data);

                //    $('.company'+companyid).remove();
                    // data masyve egzistuoja elementas errorMessage
                    // neleisti vykdyti remove() ir #alert laukeli nudazyti raudonai pagal tai kad yra nesekme
                    //kitu atveju
                    //remove () funkcija ir #alert laukeli nudazoma zaliai.
                    // ar data.errorMessage sitoje neegzistuoja
                    if($.isEmptyObject(data.errorMessage)) {
                        //sekmes atveji
                        $('#alert').removeClass('alert-danger');
                        $('#alert').addClass('alert-success');
                        $("#alert").removeClass("d-none");
                        $('.company'+companyid).remove();
                        $("#alert").html(data.successMessage);                    
                        
                    } else {
                        //nesekme
                        $('#alert').removeClass('alert-success');
                        $('#alert').addClass('alert-danger');
                        $("#alert").removeClass("d-none");
                        $("#alert").html(data.errorMessage); 
                    }



                //    $("#alert").removeClass("d-none");
                    // $("#alert").html(data.successMessage);                    
                }
            });

        });
    });
</script>    
@endsection