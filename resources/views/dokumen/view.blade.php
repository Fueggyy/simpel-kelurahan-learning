@extends('adminlte::page')

@section('title', 'Dokumen')

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
                    <h3 class="card-title">Tambah Dokumen</h3>
                </div>
                <form action="{{ route('view_detail_dokumen',$dokumen->id) }}" method="POST">
                    @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>name:</strong>
                                <input type="text" name="name" value="{{ $dokumen->name }}" class="form-control" placeholder="name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary btn-outline " href="{{ route('view_dokumen') }}">
                        <i class="icon wb-arrow-left" aria-hidden="true"></i>
                        <span class="hidden-sm-down">Cancel</span>
                    </a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection