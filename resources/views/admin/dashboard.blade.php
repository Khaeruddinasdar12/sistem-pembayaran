@extends('layouts.template')

@section('title') Dashboard @endsection

@section('content')
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Dashboard</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
				</ol>
			</div>
		</div>
	</div>
</div>
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-3 col-6">
				<div class="small-box bg-light">
					<div class="inner">
						<h3>{{$admin}}</h3>
						<p>Jumlah Admin</p>
					</div>
					<div class="icon">
						<i class="fas fa-user-cog"></i>
					</div>
					<a href="{{route('admin.index')}}" class="small-box-footer" >Lihat <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-success">
					<div class="inner">
						<h3>{{$penagih}}</h3>
						<p>Jumlah Penagih</p>
					</div>
					<div class="icon">
						<i class="fas fa-users"></i>
					</div>
					<a href="{{route('penagih.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-6">
				<div class="small-box bg-warning">
					<div class="inner">
						<h3>{{$user}}</h3>
						<p>Jumlah User</p>
					</div>
					<div class="icon">
						<i class="fas fa-user-tag"></i>
					</div>
					<a href="{{route('user.index')}}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- <div class="col-lg-3 col-6">
				<div class="small-box bg-dark">
					<div class="inner">
						<h3>5</h3>
						<p>Manage Pengecer</p>
					</div>
					<div class="icon">
						<i class="fas fa-users"></i>
					</div>
					<a href="" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
				</div>
			</div> -->
		</div>
		<!-- /.row -->
		<!-- Main row -->
		<div class="row">
			<!-- Left col -->

			<!-- right col -->
		</div>
	</div>
</section>
@endsection