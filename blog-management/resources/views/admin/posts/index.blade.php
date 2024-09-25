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
                Posts</h4>
            </div>
            <div class="col-6">
              <div class="list-product-header">
                <a id="AddPostModal" class="btn btn-primary" data-ajax-popup="false" href="javascript:void(0);" data-url="{{route('posts.create')}}">Add Post</a>
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
                  <th>Featured Image</th>
                  <th>Category</th>
                  <th>Title</th>
                  <th>Content Snippet</th>
                  <th>Publication Date</th>

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


  <div id="AddUpdatePostModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
    </div>
  </div>
</div>


<script>
  var table = "";
  $(document).ready(function() {

    table = $('#editor-datable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('posts.index') }}",

      columns: [{
          data: 'featured_image',
          name: 'featured_image'
        },
        {
          data: 'category_name',
          name: 'category_name'
        },
        {
          data: 'title',
          name: 'title'
        },
        {
          data: 'content',
          name: 'content'
        },
        {
          data: 'publication_date',
          name: 'publication_date'
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


  $(document).on('click', '#AddPostModal', function() {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      type: 'GET',
    
      success: function(response) {
        $('#AddUpdatePostModal .modal-dialog').html(response);
        $('#AddUpdatePostModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });

  
  $("#AddUpdatePostModal").on('submit', 'form', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      data: formData,
      processData: false, 
      contentType: false, 
      success: function(response) {
        $("#AddUpdatePostModal").modal('hide');
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
        $('#AddUpdatePostModal .modal-dialog').html(response);
        $('#AddUpdatePostModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  });
  $(document).on('click', '#EditPostModal', function() {
    var url = $(this).data('url');
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        $('#AddUpdatePostModal .modal-dialog').html(response);
        $('#AddUpdatePostModal').modal('show');
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