@extends('adminlte::page')

@section('title', 'CHange Password')

@section('content_header')
    <h1>Change Password</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Change Password</h3>
          </div>
          <form action="{{ route('changePasswordProfile') }}" method="POST">
            @csrf

            <div class="card-body">
              <div class="form-group">
                  <h4 class="example-title">Kata sandi saat ini</h4>
                  <input type="password" name="current_password" class="form-control {{ $errors->has('current_password') ? 'is-invalid' : null }}" id="inputPlaceholder" placeholder="Kata sandi saat ini" required>
                  @if ($errors->has('current_password'))
                      <div class="invalid-feedback">
                          {{ $errors->first('current_password') }}
                      </div>
                  @endif
              </div>

              <div class="form-group">
                  <h4 class="example-title">Kata sandi baru</h4>
                  <input type="password" name="new_password" class="form-control {{ $errors->has('new_password') ? 'is-invalid' : null }}" id="newPassword" placeholder="Kata sandi baru" autocomplete="off" required>

                  @if ($errors->has('new_password'))
                      <div class="invalid-feedback">
                          {{ $errors->first('new_password') }}
                      </div>
                  @endif
              </div>

              <div class="form-group">
                    <h4 class="example-title">Ulangi kata sandi baru</h4>
                    <input type="password" name="new_password_confirmation" class="form-control {{ $errors->has('new_password_confirmation') ? 'is-invalid' : null }}" id="repeatNewPassword" autocomplete="off" placeholder="Ulangi kata sandi baru" required>

                    @if ($errors->has('new_password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('new_password_confirmation') }}
                        </div>
                    @endif
                </div>
                <div class="example" id="strength_wrp">
                    <h4 class="example-title">Ketentuan kata sandi</h4>
                    <div id="pswd_info">
                        <ul>
                            <li><strong>Hindari menggunakan kata sandi yang sama untuk website lain;</strong></li>
                            <li class="invalid" id="length">Minimal 8 karakter;</li>
                            <li class="invalid" id="pnum">Setidaknya terdapat satu nomor;</li>
                            <li class="invalid" id="capital">Setidaknya terdapat satu huruf kecil &amp; huruf besar</li>
                            <li class="invalid" id="spchar">Selain huruf, sertakan setidaknya angka atau simbol (~!@#$%^&*_+);</li>
                            <li class="invalid" id="match">Kata sandi telah cocok</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
              <a class="btn btn-secondary btn-outline " href="{{ route('home') }}">
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
    <style>
      #pswd_info ul {
          list-style-type: none;
          margin: 5px 0 0;
          padding: 0;
      }
      #pswd_info ul li {
          background: url('{{ asset('assets/images/icon_pwd_strength.png') }}') no-repeat left 2px;
          padding: 0 0 0 20px;
      }
      #pswd_info ul li.valid {
          background-position: left -42px;
          color: green;
      }
      #pswd_info ul li.invalid {
          /*background-position: left px;*/
          color: red;
      }
  </style>
@stop

@section('js')
<script>
  $("input#newPassword").on("focus keyup", function () {
      var score = 0;
      var a = $(this).val();

      if (a.length >= 8) {
          $("#length").removeClass("invalid").addClass("valid");
          score++;
      } else {
          $("#length").removeClass("valid").addClass("invalid");
      }

      // at least 1 digit in password
      if (a.match(/\d/)) {
          $("#pnum").removeClass("invalid").addClass("valid");
          score++;
      } else {
          $("#pnum").removeClass("valid").addClass("invalid");
      }

      // at least 1 capital & lower letter in password
      if (a.match(/[A-Z]/) && a.match(/[a-z]/)) {
          $("#capital").removeClass("invalid").addClass("valid");
          score++;
      } else {
          $("#capital").removeClass("valid").addClass("invalid");
      }

      // at least 1 special character in password {
      if ( a.match(/.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/) ) {
          $("#spchar").removeClass("invalid").addClass("valid");
          score++;
      } else {
          $("#spchar").removeClass("valid").addClass("invalid");
      }
  });

  $("input#repeatNewPassword").on("focus keyup", function () {
      if ($('input#newPassword').val() == $('input#repeatNewPassword').val()) {
          $("#match").removeClass("invalid").addClass("valid");
          $('#submitButton').attr('disabled', false);
      } else {
          $("#match").removeClass("valid").addClass("invalid");
          $('#submitButton').attr('disabled', true);
      }
  });
</script>
@stop