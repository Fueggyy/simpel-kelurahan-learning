@extends('adminlte::page')

@section('title', 'Dokumen')

@section('content_header')
    <div class="row mt-5 mb-5">
        <div class="col-lg-12 margin-tb">
            <div class="float-left">
                <h2>Edit Dokumen</h2>
            </div>
            <div class="float-right">
                <a class="btn btn-secondary" href="{{ route('view_dokumen') }}"> Back</a>
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
 
    <form action="{{ route('view_detail_dokumen',$dokumen->id) }}" method="POST">
        @csrf
        {{--  @method('PUT')  --}}
 
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>name:</strong>
                    <input type="text" name="name" value="{{ $dokumen->name }}" class="form-control" placeholder="name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
 
    </form>
@endsection