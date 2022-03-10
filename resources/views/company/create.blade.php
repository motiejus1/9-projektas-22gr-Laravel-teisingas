@extends('layouts.app')

@section('content')
<div class="container">
   
    <form action="{{route('company.store')}}" method="POST"> 
        @csrf     
        <div class="form-group">
            <label for="company_title">Company Title</label>
            <input class="form-control" type="text" name="company_title" />
        </div>
        <div class="form-group">
            <label for="company_description">Company Description</label>
            <input class="form-control" type="text" name="company_description" />
        </div>

        <div class="form-group">
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
        
    </form>
</div>
@endsection