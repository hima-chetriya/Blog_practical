@extends('layouts.backend.main')
@section('content')


<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="container-fluhjhjid">
        <div class="page-title">
          <div class="row">
            <div class="col-6">
              <h4>
                Categories</h4>
            </div>
            <div class="col-6">
              <div class="list-product-header">
                <a id="AddCategoriesModal" class="btn btn-primary" data-ajax-popup="false" href="javascript:void(0);" data-url="{{route('categories.create')}}">Add Category</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <div class="list-product">
            <table class="display" id="editor-datable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div id="AddUpdateCategoryModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
    </div>
  </div>
</div>


<script>
  var table = "";
  $(document).ready(function() {

    table = $('#editor-datable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('categories.index') }}",

      columns: [
        {
          data: 'name',
          name: 'name'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: false
        }
      ]
    });
  });

  // Modal Load
  $(document).on('click', '#AddCategoriesModal', function() {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      type: 'GET',
      // dataType: 'html',
      success: function(response) {

        $('#AddUpdateCategoryModal .modal-dialog').html(response);
        $('#AddUpdateCategoryModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });

  // Data Save
  $("#AddUpdateCategoryModal").on('submit', 'form', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      processData: false, 
      contentType: false, 
      success: function(response) {
        $("#AddUpdateCategoryModal").modal('hide');
        notify(response.success);
        table.draw();
      },
      error: function(xhr, status, error) {
        var errors = xhr.responseJSON.errors;
        $(".is-error-message").remove();
        $.each(errors, function(key, value) {
          var ele = "#" + key;
          $(ele).addClass('is-invalid');
          $('<div class="is-error-message invalid-feedback text-danger">' +
              value +
              '</div>')
            .insertAfter(ele);
        });
      }
    });
  });


  $(document).on('click', '#ShowModal', function() {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        // alert(response);
        $('#AddUpdateCategoryModal .modal-dialog').html(response);
        $('#AddUpdateCategoryModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });
  $(document).on('click', '#EditCategoryModal', function() {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        // alert(response);
        $('#AddUpdateCategoryModal .modal-dialog').html(response);
        $('#AddUpdateCategoryModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });


  // Delete
  $(document).on('click', '.delete', function(e) {
    e.preventDefault();
    swal.fire({
      title: 'Are you sure?',
      text: 'You won\'t be able to revert this!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "DELETE",
          url: $(this).data('url'),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            if (response.status == 1) {
              swal.fire(
                'Deleted!',
                'Your user has been deleted.',
                'success'
              );

              table.draw();

            }
          },
          error: function(response) {
            swal.fire(
              'Error!',
              'Failed to delete user.',
              'error'
            );
          }
        });
      }
    });
  });
</script>
@endsection