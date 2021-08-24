<h3>Laporan {{$bulan}} {{$tahun}}</h3>
@php $no = 1; @endphp
<table border="1">
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
	@foreach($data as $dt)
	<tr>
		<td>{{$no++}}</td>
		<td>{{$dt->user->name}}</td>
		<td>{{$dt->user->alamat}}</td>
		<td>{{$dt->meter_bulan_lalu}} m<sup>3</sup></td>
		<td>{{$dt->meter_bulan_ini}} m<sup>3</sup></td>
		<td>{{$dt->pemakaian}} m<sup>3</sup></td>
		<td>@if($dt->status == 1) LUNAS @else BELUM LUNAS @endif</td>
		<td>{{$dt->created_at}}</td>
		<td>Rp. {{ format_uang($dt->total) }}</td>
	</tr>
	@endforeach
</table>