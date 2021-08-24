@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><i class="nav-icon fas fa-wallet"></i> Tagihan <span class="badge badge-danger"><i class="nav-icon fas fa-times-circle"></i> Belum Lunas !</span></div>
                @php $name = Auth::user()->name; @endphp
                @foreach($data as $dt)
                <div class="card-body">
                    <table>
                        <tr>
                            <td>Nama Pelanggan</td>
                            <td> : </td>
                            <td>{{$name}}</td>
                        </tr>
                        <tr>
                            <td>Dusun</td>
                            <td> : </td>
                            <td>Pungkalawaki</td>
                        </tr>
                        <tr>
                            <td>Stand Meter</td>
                            <td> : </td>
                            <td>{{$dt->meter_bulan_ini}} m<sup>3</sup></td>
                        </tr>
                        <tr>
                            <td>Jumlah Biaya</td>
                            <td> : </td>
                            <td><strong>Rp. {{format_uang($dt->total)}}</strong></td>
                        </tr>
                        <tr>
                            <td>Waktu Tagihan</td>
                            <td> : </td>
                            <td>{{$dt->created_at}}</td>
                        </tr>
                        <tr>
                            <td>Di Tagih Oleh</td>
                            <td> : </td>
                            <td>{{$dt->admin->name}}</td>
                        </tr>
                    </table>
                    <p class="text-danger"></p>
                </div>
                <hr>
                @endforeach
                {{$data->links()}}
            </div>
        </div>
    </div>
</div>
@endsection