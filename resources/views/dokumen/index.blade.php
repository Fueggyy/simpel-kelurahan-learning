@extends('adminlte::page')

@section('title', 'Dokumen')

@section('content_header')
    <h1></h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
            @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <strong>{{ $message }}</strong>
            </div>
            @endif
            @if ($errors->any())
                <div class="error card-body alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>  
    <div class="row">
      <div class="col-md-12">
        <div class="card-header bg-primary">
            <h3 class="card-title">Dokumen</h3>
        </div>
        <div class="card card-primary">
            <div class="card-body">
                {!! $dataTable->table() !!}
            </div>
        </div>
      </div>
    </div>
</div>

@stop

@section('css')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
@stop

@section('js')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
<script>
    function viewDokumen(id) {
        window.location.href = "{{ url('dokumen/view') }}/" + id;
    }

    function deleteDokumen(id) {
        swal({
            title: "Delete?",
            text: "Please ensure and then confirm!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: !0
        }).then(function (e) {

            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax_dokumen_delete') }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        id: id
                    }),
                    dataType: 'JSON',
                    contentType: 'application/json',
                    beforeSend: function() {
                        swal({
                            html: '<h5>Loading...</h5>',
                            showConfirmButton: false,
                            onRender: function() {
                                 // there will only ever be one sweet alert open.
                                 $('.swal2-content').prepend(sweet_loader);
                            }
                        });
                    },
                    success: function(res) {
                        swal("Done!", res.description, "success");
    
                        if (res.success === true) {
                            swal("Done!", res.description, "success");
                            location.reload();
                        }else{
                            swal("Error!", res.description, "error");
                        }
                    },
                    error: function(res) {
                        swal("Error!", res, "error");
                    }
                });

            } else {
                e.dismiss;
            }

        }, function (dismiss) {
            return false;
        })
    }
</script>
@stop