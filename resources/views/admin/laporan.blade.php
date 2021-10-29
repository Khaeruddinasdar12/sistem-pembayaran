@extends('layouts.template')

@section('title')
Laporan
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
</div>
<!-- /.content-header -->
<section class="content">
  <div class="row">
    <div class="col-12">

      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-chart-bar"></i> Laporan {{$bulan}} {{Request::get('tahun')}}</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">

          @if(session('error'))
          <div class="alert alert-danger">
            <strong>{{session('error')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            
          </div>
          @endif

          <div class="row">
            <div class="col-12">

              <div class="float-right">
                <div class="row">
                  <form action="{{route('laporan')}}" method="get">
                    <select class="form-control-sm" name="status">
                      <option value="">pilih status</option>
                      <option value="1" @if(Request::get('status')=='1' ) {{"selected"}} @endif>Lunas</option>
                      <option value="0" @if(Request::get('status')=='0' ) {{"selected"}} @endif>Belum Lunas</option>
                    </select>
                    <select class="form-control-sm" name="bulan">
                      <option value="">pilih bulan</option>
                      <option value="1" @if(Request::get('bulan')=='1' ) {{"selected"}} @endif>Januari</option>
                      <option value="2" @if(Request::get('bulan')=='2' ) {{"selected"}} @endif>Februari</option>
                      <option value="3" @if(Request::get('bulan')=='3' ) {{"selected"}} @endif>Maret</option>
                      <option value="4" @if(Request::get('bulan')=='4' ) {{"selected"}} @endif>April</option>
                      <option value="5" @if(Request::get('bulan')=='5' ) {{"selected"}} @endif>Mei</option>
                      <option value="6" @if(Request::get('bulan')=='6' ) {{"selected"}} @endif>Juni</option>
                      <option value="7" @if(Request::get('bulan')=='7' ) {{"selected"}} @endif>Juli</option>
                      <option value="8" @if(Request::get('bulan')=='8' ) {{"selected"}} @endif>Agustus</option>
                      <option value="9" @if(Request::get('bulan')=='9' ) {{"selected"}} @endif>September</option>
                      <option value="10" @if(Request::get('bulan')=='10' ) {{"selected"}} @endif>Oktober</option>
                      <option value="11" @if(Request::get('bulan')=='11' ) {{"selected"}} @endif>November</option>
                      <option value="12" @if(Request::get('bulan')=='12' ) {{"selected"}} @endif>Desember</option>
                    </select>
                    <select class="form-control-sm" name="tahun">
                      <option value="">pilih tahun</option>
                      <option value="2021" @if(Request::get('tahun')=='2021' ) {{"selected"}} @endif>2021</option>
                      <option value="2022" @if(Request::get('tahun')=='2022' ) {{"selected"}} @endif>2022</option>
                    </select>
                    <button type="submit" class="btn btn-outline-secondary"><i class="fas fa-search"></i> filter</button>
                  </form>


                  <form action="{{ route('laporan.pdf') }}" method="post">
                    @csrf
                    <input type="hidden" name="status" value="{{Request::get('status')}}">
                    <input type="hidden" name="bulan" value="{{Request::get('bulan')}}">
                    <input type="hidden" name="tahun" value="{{Request::get('tahun')}}">
                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-file-pdf"></i> PDF</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <br>
          @php $no = 1; @endphp
          <div class="table-responsive-sm">
            <table class="table table-bordered" style="width:100% !important; ">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Alamat</th>
                  <th>Bulan Lalu</th>
                  <th>Bulan Ini</th>
                  <th>Pemakaian</th>
                  <th>Status</th>
                  <th>Waktu</th>
                  <th>Total</th>
                </tr>
              </thead>
              <tbody>
                @php $total = 0; @endphp
                @foreach($data as $dt)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$dt->user->name}}</td>
                  <td>{{$dt->user->alamat}}</td>
                  <td>{{$dt->meter_bulan_lalu}} m<sup>3</sup></td>
                  <td>{{$dt->meter_bulan_ini}} m<sup>3</sup></td>
                  <td>{{$dt->pemakaian}} m<sup>3</sup></td>
                  <td>@if($dt->status == '0') <span class="badge badge-pill badge-warning">Belum Lunas</span> @else <span class="badge badge-pill badge-success">Lunas</span> @endif
                  </td>
                  <td>{{$dt->created_at}}</td>
                  <td>Rp. {{ format_uang($dt->total) }}</td>
                </tr>
                @php $total = $dt->total + $total; @endphp
                @endforeach
                <tr>
                  <td colspan="8" align="center"><b>Sub Total</b></td>
                  <td><b>Rp. {{ format_uang($total) }}</b></td>
                </tr>
                <tr>
                  <td colspan="8" align="center"><b>Grand Total</b></td>
                  <td><b>Rp. {{ format_uang($grandTotal) }}</b></td>
                </tr>
                
              </tbody>
            </table>
            {{$data->appends(['status' => Request::get('status'), 'bulan' => Request::get('bulan'), 'tahun' => Request::get('tahun')])->links()}}
          </div>

        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<script type="text/javascript">

  function berhasil(status, pesan) {
    Swal.fire({
      type: status,
      title: pesan,
      showConfirmButton: true,
      button: "Ok"
    })
  } 

  function gagal(key, pesan) {
    Swal.fire({
      type: 'error',
      title:  key + ' : ' + pesan,
      showConfirmButton: true,
      timer: 25500,
      button: "Ok"
    })
  }

  tabel = $(document).ready(function(){
    $('#tabel_penagih').DataTable({
      "processing": true,

      "serverSide": true,
      "deferRender": true,
      "ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.penagih")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "name" },
              { "data": "email" },
              ]
            });
  });
</script>
@endsection