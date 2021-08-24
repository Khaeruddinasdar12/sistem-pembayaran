@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><i class="nav-icon fas fa-user"></i> Profile</div>

        <div class="card-body">
          @if (count($errors) > 0)
          <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Whoops!</strong><br>
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
            
          </div>
          @endif
          <form action="{{ route('ubah.password') }}" method="post">
            @csrf
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Nama </label>
              <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{Auth::user()->name}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Email </label>
              <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{Auth::user()->email}}">
              </div>
            </div>
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Alamat </label>
              <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{Auth::user()->alamat}}">
              </div>
            </div>
            <hr>

            <div class="alert alert-warning">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Hati-hati!</strong> Menekan tombol simpan akan langsung mengubah password Anda.

            </div>

            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Password Baru </label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Ulangi Password </label>
              <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="password_confirmation">
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
