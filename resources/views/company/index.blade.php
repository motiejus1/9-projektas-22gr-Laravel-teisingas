@extends('layouts.app')

@section('content')
<div class="container">
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
        </tr>
        @foreach ($companies as $company)
        <tr>
            <td>{{$company->id}}</td>
            <td>{{$company->title}}</td>
            <td>{{$company->description}}</td>
        </tr>
        @endforeach
    </table>
</div>    
@endsection