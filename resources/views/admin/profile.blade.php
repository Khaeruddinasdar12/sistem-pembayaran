@extends('layouts.template')

@section('title')
Profile
@endsection

@section('content')
<div class="content-header">
</div>
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-user-cog"></i> Profile</h2>
        </div>
        <div class="card-body">
          @if(session('success'))
          <div class="alert alert-success">
            <strong>{{session('success')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            
          </div>
          @endif

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

          <form action="{{route('admin.profile')}}" method="post">
            @csrf
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
              <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ Auth::guard('admin')->user()->email }}">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Nama</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name }}" name="nama">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-2 col-form-label">Konfirmasi Password</label>
              <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirmation">
              </div>
            </div>
            <button type="submit" class="btn btn-primary ">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


@endsection