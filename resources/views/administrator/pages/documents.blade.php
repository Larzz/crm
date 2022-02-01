@extends('administrator.layouts.default')
@include('administrator.includes.uploaders')
@section('content')
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    @include('administrator.includes.top_nav')
    <!-- Header -->
    @include('administrator.includes.navigation')
    <!-- Page content -->
    <div class="container-fluid mt--6">
      <br/>
      <br/>
      <br/>
      <br/>
      <div class="row">
        <div class="table-responsive">
          <!-- Projects table -->
          <table class="table align-items-center table-flush">
            <thead class="thead-light">
              <tr>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Client Name</th>
                <th scope="col text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($documents as $item)
                <tr>
                  <th scope="row"> {{ $item->filename }} </th>
                  <td> {{ $item->filename_desc }}</td>
                  <td>  {{ $item->client_name }} </td>
               

                <td class="">
                  <div class="dropdown">
                      <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        <a class="dropdown-item" href="#">Delete</a>
                        <a class="dropdown-item" href="#">Update</a>
                        <a class="dropdown-item" href="#">Download</a>
                      </div>
                  </div>
              </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
       

      <!-- Footer -->
      @include('administrator.includes.footer')
      <div class="modal fade" id="add_document" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Document</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="form_document" action="javascript:;" method="post">
                <div class="form-group">
                  <label for="exampleInputEmail1">Title</label>
                  <input type="text" name="name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Description</label>
                  <input type="text" name="description" class="form-control" id="exampleInputPassword1" placeholder="Enter Description">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Client</label>
                  <select class="form-control" name="client_id" id="exampleFormControlSelect2">
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                  </select>                </div>
                <div class="form-group">
                  <div id="fine-uploader-gallery"></div>
                  </div>
                  <input type="hidden" name="attachment" id="attachment">
                <button type="submit" class="btn btn-primary" id="btn_save_document">Submit</button>
              </form>
             </div>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
    
  </div>
@endsection

@section('js')

<link rel="stylesheet" href="{{ asset('src/css/fineuploader.css') }}">
<script src="{{ asset('src/js/administrator.js') }}"></script>
<script src="{{ asset('src/js/fine-uploader.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>


 const UPLOAD_DOCUMENT = '{{ route('admin.upload_document') }}'
 const CREATE_DOCUMENT = '{{ route('admin.save_document') }}'

$(function() {

  $('#new_document').click(function() {
      $('#add_document').modal('show')
  });

  $('#btn_save_document').click(function() {
    
      var client_name = $('#exampleFormControlSelect2').find('option:selected').text();
      var form = $('#form').serialize();
      var $this = $(this);

      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: 'btn btn-success',
          cancelButton: 'btn btn-danger'
        },
        buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
        title: client_name,
        text: "Are you sure you want to add the file for:",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Save it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
      }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                type: 'POST',
                url: CREATE,
                data: form,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function() {
                },
                success: function(data) {

                  swalWithBootstrapButtons.fire(
                    'ADDED!',
                    'Your file has been ADDED.',
                    'success'
                  )
                  
                  $this.removeAttr('disabled', 'disabled').html('Save');
                  window.location.reload();
                },
                beforeSend: function() {
                  $this.attr('disabled', 'disabled').html('Please Wait..');
                }
            });
        
        } else if (
          /* Read more about handling dismissals below */
          result.dismiss === Swal.DismissReason.cancel
        ) {
          // swalWithBootstrapButtons.fire(
          //   'Cancelled',
          //   'Your imaginary file is safe :)',
          //   'error'
          // )
        }
      })


  });

});

$('#fine-uploader-gallery').fineUploader({
    template: 'qq-template-gallery',
    request: {
        endpoint: UPLOAD_DOCUMENT,
        customHeaders: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
    },
    thumbnails: {
        placeholders: {
            waitingPath: '/source/placeholders/waiting-generic.png',
            notAvailablePath: '/source/placeholders/not_available-generic.png'
        }
    },
    validation: {
        allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'pdf']
    },
    callbacks: {
          onComplete: function(id, name, response) {
              $('#attachment').val(response.filename)
          }
      }
});

</script>

@endsection