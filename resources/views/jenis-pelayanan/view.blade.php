@extends('adminlte::page')

@section('title', 'Jenis Pelayanan')

@section('content_header')
<h1></h1>
@stop
 
@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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
      </div>
    </div>  
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Edit Jenis Pelayanan</h3>
                </div>
                <form action="{{ route('view_detail_jenis_pelayanan',$JenisPelayanan->id) }}" method="POST">
                    @csrf
                <div class="card-body">
            
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
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Dokumen :</strong>
                                <div class="row">
                                    @foreach($dokumen as $dok)
                                        <div class="col-md-4">
                                            <input type="checkbox" name="dokumen[]" value="{{ $dok->id }}" {{ in_array($dok->id,$dataDD) ? "checked" : "" }}>  {{ $dok->name }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
            
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a class="btn btn-secondary btn-outline " href="{{ route('view_jenis_pelayanan') }}">
                        <i class="icon wb-arrow-left" aria-hidden="true"></i>
                        <span class="hidden-sm-down">Cancel</span>
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endsection