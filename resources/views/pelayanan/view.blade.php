@extends('adminlte::page')

@section('title', 'Pelayanan')

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
                    <h3 class="card-title">Edit Pelayanan</h3>
                </div>
                <div class="card-body">
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
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Upload Dokumen</h3>
                </div>
                <div class="card-body">
                    <table  class="table table-bordered table-striped">
                        <tr style="background-color: red;color:white;">
                            <td>Dokumen</td>
                            <td>Aksi</td>
                        </tr>
                        @foreach($pelayananDetail as $pd)
                        <tr>
                            <td>{{ $pd->dok->name }}</td>
                            <td>
                            @if(empty($pd->dokumen))
                                <form method="POST" id="dok-{{$pd->id}}" action="{{ route('upload_dokumen_pelayan', ['id' => $pd->id])}}" enctype="multipart/form-data">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" name="dokumen" id="dokumen-{{$pd->id}}" class="form-control">
                                        </div>    
                                        <div class="col-md-6">
                                            <button type="submit" id="btn-{{$pd->id}}" class="btn btn-primary">Upload</button> 
                                        </div>
                                    </div>    
                                </form>
                            @else
                                <a href="{{url('/')}}/storage/pelayanan/{{$pd->pelayanan_id}}/{{$pd->dokumen}}" target="_blank"><button class="btn btn-primary">View</button></div>
                            @endif
                            </td>
                        </tr> 
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection