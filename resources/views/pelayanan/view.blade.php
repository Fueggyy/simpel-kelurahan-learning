@extends('adminlte::page')

@section('title', 'Pelayanan')

@section('content_header')
    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Edit Pelayanan</h2>
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
 
    <form action="{{ route('view_detail_pelayanan',$Pelayanan->id) }}" method="POST">
        @csrf
        {{--  @method('PUT')  --}}
 
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Jenis Pelayanan :</strong>
                    <select class="form-control" name="jenis_pelayanan_id" id="jenis_pelayanan_id">
                        <option value="">-- Jenis Pelayanan --</option>
                        @foreach($JenisPelayanan as $jp)
                            <option value="{{ $jp->id }}" {{ $jp->id==$Pelayanan->jenis_pelayanan_id ? "selected" : "" }}>{{ $jp->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>nomor :</strong>
                    <input type="text" name="nomor" value="{{ $Pelayanan->nomor }}" class="form-control" placeholder="nomor">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>NIK :</strong>
                    <input type="text" name="nik" value="{{ $Pelayanan->nik }}" class="form-control" placeholder="nik">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>name:</strong>
                    <input type="text" name="name" value="{{ $Pelayanan->name }}" class="form-control" placeholder="name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Alamat :</strong>
                    <input type="text" name="address" value="{{ $Pelayanan->address }}" class="form-control" placeholder="address">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
 
    </form>
@endsection