@extends('adminlte::page')

@section('title', 'Jenis Pelayanan')

@section('content_header')
    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Edit Jenis Pelayanan</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('view_jenis_pelayanan') }}"> Back</a>
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
 
    <form action="{{ route('view_detail_jenis_pelayanan',$JenisPelayanan->id) }}" method="POST">
        @csrf
        {{--  @method('PUT')  --}}
 
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Kode :</strong>
                    <input type="text" name="code" value="{{ $JenisPelayanan->code }}" class="form-control" placeholder="code">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>name:</strong>
                    <input type="text" name="name" value="{{ $JenisPelayanan->name }}" class="form-control" placeholder="name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
 
    </form>
@endsection