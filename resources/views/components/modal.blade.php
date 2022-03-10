<div class="modal fade" id="createClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Create Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <div class="form-group">
              <label for="client_description">Client Description</label>
              <select id="client_company_id" class="form-select">
                @foreach ($companies as $company)
                  <option value="{{$company->id}}">{{$company->title}}</option>
                @endforeach
              </select>  
            </div>
        </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            {{-- <button id="close-client-create-modal" type="button" class="btn btn-secondary">Close with Javascript</button> --}}
            <button id="submit-ajax-form" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="editClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="ajaxForm">
            <input type="hidden" id="edit_client_id" name="client_id" />
            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input id="edit_client_name" class="form-control" type="text" name="client_name" />
            </div>
            <div class="form-group">
                <label for="client_surname">Client Surname</label>
                <input id="edit_client_surname" class="form-control" type="text" name="client_surname" />
            </div>
            <div class="form-group">
                <label for="client_description">Client Description</label>
                <input id="edit_client_description" class="form-control" type="text" name="client_description" />
            </div>
            <div class="form-group">
              <label for="client_description">Client Company id</label>
              <select id="edit_client_company_id" class="form-select">
                @foreach ($companies as $company)
                  <option class="company{{$company->id}}" value="{{$company->id}}">{{$company->title}}</option>
                @endforeach
              </select>  
            </div>
        </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            {{-- <button id="close-client-create-modal" type="button" class="btn btn-secondary">Close with Javascript</button> --}}
            <button id="update-client" type="button" class="btn btn-primary">Update</button>
        </div>
      </div>
    </div>
  </div>
  
  <div class="modal fade" id="showClientModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Show Client</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="show-client-id">
            </div>  
            <div class="show-client-name">
            </div>
            <div class="show-client-surname">
            </div>  
            <div class="show-client-description">
            </div>
            <label>Company</label>
            <div class="show-client-company">
            </div>     
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>