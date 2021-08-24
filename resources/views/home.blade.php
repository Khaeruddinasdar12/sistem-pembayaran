@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><i class="nav-icon fas fa-tachometer-alt"></i> {{ __('Dashboard') }}</div>

        <div class="card-body">
          <div class="alert alert-success" role="alert">
            <i class="nav-icon fas fa-door-open"></i> Selamat Datang {{Auth::user()->name}} - <a href="{{route('profile')}}" class="text-info">Profile</a>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><i class="nav-icon fas fa-wallet"></i> Lihat Tagihan Anda</h5>
                  <p class="card-text">Semua Tagihan Anda saat ini.</p>
                  <a href="{{route('tagihan')}}" class="btn btn-outline-primary btn-sm"><i class="nav-icon fas fa-share"></i> Lihat</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title"><i class="nav-icon fas fa-chart-bar"></i> Riwayat Tagihan Anda</h5>
                  <p class="card-text">Seluruh data yang telah dibayar</p>
                  <a href="{{route('riwayat.tagihan')}}" class="btn btn-outline-primary btn-sm"><i class="nav-icon fas fa-share"></i> Lihat</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
