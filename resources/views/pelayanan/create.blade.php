@extends('adminlte::page')

@section('title', 'Pelayanan')

@section('content_header')
    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Create New Pelayanan</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('view_pelayanan') }}"> Back</a>
            </div>
        </div>
    </div>
@stop
 
@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
<form action="{{ route('create_pelayanan') }}" method="POST">
    @csrf
 
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jenis Pelayanan :</strong>
                <select class="form-control" name="jenis_pelayanan_id" id="jenis_pelayanan_id">
                    <option value="">-- Jenis Pelayanan --</option>
                    @foreach($JenisPelayanan as $jp)
                        <option value="{{ $jp->id }}">{{ $jp->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>nomor :</strong>
                <input type="text" name="nomor" id="nomor" class="form-control" placeholder="X/X/X/XXXX" readonly>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>nik :</strong>
                <input type="text" name="nik" class="form-control" placeholder="nik">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama :</strong>
                <input type="text" name="name" class="form-control" placeholder="name">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Alamat :</strong>
                <input type="text" name="address" class="form-control" placeholder="address">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
 
</form>
@endsection
@section('js')
<script>
    $( "#jenis_pelayanan_id" ).change(function() {
        let jenis_pelayanan_id = $( this ).val();
        $.ajax({
            type: 'POST',
            url: '{{ route('ajax_nomor_pelayanan') }}',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                jenis_pelayanan_id: jenis_pelayanan_id
            }),
            dataType: 'JSON',
            contentType: 'application/json',
            success: function(res) {
                {{--  alert( res.data );  --}}
                $( "#nomor" ).val(res.data);
            },
            error: function(res) {
                alert( res.description );
            }
        });
        {{--  alert( jenis_pelayanan_id );  --}}
      });
</script>
@stop