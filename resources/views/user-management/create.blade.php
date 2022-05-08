@extends('adminlte::page')

@section('title', 'User Management')

@section('content_header')
    <br>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
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
        <div class="card card-primary">
          <div class="card-header bg-primary">
            <h3 class="card-title">Tambah User</h3>
          </div>
          <form method="POST" id="quickForm" action="{{ route('create_user') }}">
            @csrf
            <div class="card-body">
              <!-- <div class="form-group">
                <label for="employee_id">ID</label>
                <input type="name" name="employee_id" class="form-control {{ $errors->has('employee_id') ? 'is-invalid' : null }}" id="employee_id" value="{{ old('employee_id') }}" placeholder="Enter id" required>
                @if ($errors->has('employee_id'))
                    <span class="error invalid-feedback">
                        {{ $errors->first('employee_id') }}
                      </span>
                @endif  
              </div> -->
              <div class="form-group">
                <label for="name">Name</label>
                <input type="name" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : null }}" id="name" value="{{ old('name') }}" placeholder="Enter name" required>
                @if ($errors->has('name'))
                    <span class="error invalid-feedback">
                        {{ $errors->first('name') }}
                      </span>
                @endif  
              </div>
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : null }}" id="email" value="{{ old('email') }}" placeholder="Enter email" required>
                @if ($errors->has('email'))
                    <span class="error invalid-feedback">
                        {{ $errors->first('email') }}
                      </span>
                @endif  
              </div>
              <div class="form-group">
                <label for="role_id">Roles</label>
                <select class="form-control {{ $errors->has('role_id') ? 'is-invalid' : null }}" name="role_id" id="role_id" required>
                  <option value="">-- ROLES --</option>
                  @foreach($roles as $r)
                      <option value="{{ $r->id }}">{{ $r->name }}</option>
                  @endforeach
                </select>                
                @if ($errors->has('role_id'))
                    <span class="error invalid-feedback">
                        {{ $errors->first('role_id') }}
                      </span>
                @endif  
              </div>         
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : null }}" id="password" autocomplete="off" placeholder="Enter password" required>
                @if ($errors->has('password'))
                    <span class="error invalid-feedback">
                        {{ $errors->first('password') }}
                      </span>
                @endif  
              </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-secondary btn-outline " href="{{ route('view_user') }}">
                <i class="icon wb-arrow-left" aria-hidden="true"></i>
                <span class="hidden-sm-down">Cancel</span>
              </a>
            </div>
          </form>
        </div>
        </div>
      <div class="col-md-6">
      </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="{{url('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{url('vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@stop

@section('js')
<script src="{{url('vendor/select2/js/select2.min.js') }}"></script>
@stop