@extends('layouts.template')

@section('title')
Penagihan
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="content-header">
</div>

<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-calendar"></i> Penagihan</h2>
        </div>
        <div class="card-body">
          <div class="alert alert-light">
            <table>
              <tr>
                <td>Nama</td>
                <td>:</td>
                <td>{{$user->name}}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>:</td>
                <td>@if($user->status == '0') <span class="badge badge-pill badge-warning">Tidak Aktif</span> @else <span class="badge badge-pill badge-success">Aktif</span> @endif</td>
              </tr>
              <tr>
                <td>Email</td>
                <td>:</td>
                <td>{{$user->email}}</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{$user->alamat}}</td>
              </tr>
            </table>
          </div>

          <div class="card">
            <div class="card-body">
             <div class="float-left">
              <h4 >Laporan Tagihan</h4>
            </div>
            @if($user->status == '1')
            <div class="float-right">
              <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-tagihan"><i class="fa fa-plus"></i> Tambah Tagihan</button>
            </div>
            <br> 
            <br>
            @endif

            <div class="table-responsive-sm">
              <table class="table table-bordered" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Bulan Lalu (m<sup>3</sup>)</th>
                    <th>Bulan Ini (m<sup>3</sup>)</th>
                    <th>Pemakaian (m<sup>3</sup>)</th>
                    <th>Penagihan</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                  </tr>
                </thead> 
                @php $no = 1; @endphp
                <tbody>
                  @foreach($laporan as $dt)
                  <tr>
                    <td>{{$no++}}</td>
                    <td>{{$dt->meter_bulan_lalu}}</td> {{-- bulan lalu --}}
                    <td>{{$dt->meter_bulan_ini}}</td> {{-- bulan ini --}}
                    <td>{{$dt->pemakaian}}</td> {{-- bulan lalu - meter --}}
                    <td>{{$dt->created_at}}</td>
                    <td>
                      @if($dt->status == '0')
                      <span class="badge badge-danger">Belum lunas</span>
                      @else
                      <span class="badge badge-success">lunas</span>
                      @endif
                    </td>
                    <td>Rp. {{format_uang($dt->total)}}</td>
                    <td>
                      <button 
                      class="btn btn-info btn-xs" 
                      data-toggle="modal" 
                      data-target="#detail-tagihan" 
                      title="Detail Tagihan"
                      data-bulan_lalu="{{$dt->meter_bulan_lalu}}"
                      data-bulan_ini="{{$dt->meter_bulan_ini}}"
                      data-pemakaian="{{$dt->pemakaian}}"
                      data-total="Rp. {{ format_uang($dt->total) }}"
                      data-penagihan="{{$dt->created_at}}"
                      data-status="{{$dt->status}}"
                      data-lunas_at="{{$dt->lunas_at}}"
                      data-admin="{{$dt->admin->name}}"
                      data-admin_id="{{$dt->admin->id}}" 
                      >
                      <i class="fa fa-eye"></i> 
                    </button>
                    @if($dt->status == '0')
                    <button class="btn btn-success btn-xs" title="Lunaskan Tagihan" 
                    href="{{$dt->id}}"
                    onclick="lunas()"
                    id="lunas_id">
                    <i class="fa fa-check"></i> 
                  </button>
                  @else
                  <button class="btn btn-success btn-xs" title="Kembalikan Status Tagihan" 
                  href="{{$dt->id}}"
                  onclick="undo()"
                  id="lunas_id">
                  <i class="fa fa-undo"></i> 
                </button>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody> 
        </table>
        {{$laporan->links()}}
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
</section>

<!-- MODAL -->

<!-- Modal Tambah -->
<div class="modal fade bd-example-modal" id="tambah-tagihan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="add-tagihan">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Tagihan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Jumlah Meter Bulan Lalu (m<sup>3</sup>)</label>
            <input type="text" class="form-control" name="meter_bulan_lalu" value="{{$last}}" disabled="">
          </div>
          <div class="form-group">
            <label>Jumlah Meter Bulan Ini (m<sup>3</sup>)</label>
            <input type="text" class="form-control" name="meter_bulan_ini" onkeyup="check(this.value)" id="bulan_ini">
          </div>
          <p class="text-muted" id="pemakaian">Pemakaian : </p>
          <p class="text-danger" id="hasil"><strong>Total Tagihan : Rp. 0 -,</strong></p>
          
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="cek" value="1">
            <label class="form-check-label" for="exampleCheck1">Bayar Sekarang ?</label>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Tambah</button>
        </div>
      </div>
    </form>
  </div>
</div>
<!-- End Modal Tambah -->

<!-- Modal Detail -->
<div class="modal fade bd-example-modal" id="detail-tagihan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Tagihan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <table>
          <tr>
            <td>Jumlah Meter Bulan Lalu </td>
            <td> : </td>
            <td id="bulan_ini"></td>
          </tr>
          <tr>
            <td>Jumlah Meter Bulan Ini </td>
            <td> : </td>
            <td id="bulan_lalu"></td>
          </tr>
          <tr>
            <td>Pemakaian </td>
            <td> : </td>
            <td id="pemakaian"></td>
          </tr>
          <tr>
            <td>Total Tagihan </td>
            <td> : </td>
            <td id="total"></td>
          </tr>  
          <tr>
            <td>Waktu Tagihan </td>
            <td> : </td>
            <td id="penagihan"></td>
          </tr>
          <tr>
            <td>Status Tagihan </td>
            <td> : </td>
            <td id="status"></td>
          </tr>
          <tr>
            <td>Di bayar pada </td>
            <td> : </td>
            <td id="lunas_at"></td>
          </tr>
          <tr>
            <td>Admin </td>
            <td> : </td>
            <td id="admin"></td>
          </tr>
        </table>  
      </div>
    </div>
  </div>
</div>
<!-- End Modal Detail -->
<!-- END MODALS -->
@endsection

@section('js')
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script type="text/javascript">
  $('#detail-tagihan').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var bulan_lalu = button.data('bulan_lalu') 
  var bulan_ini = button.data('bulan_ini') 
  var pemakaian = button.data('pemakaian') 
  var total = button.data('total')  
  var penagihan = button.data('penagihan')
  var status = button.data('status')
  var lunas_at = button.data('lunas_at')
  var admin = button.data('admin')
  var admin_id = button.data('admin_id')

  if(status == '1') {
    sts = "<span class='badge badge-success'>lunas</span>";
  } else {
    sts = "<span class='badge badge-danger'>Belum lunas</span>";
  }

  if(admin == '1') {
    adm = "Penagih";
  } else {
    adm = "Administrator";
  }   

  var modal = $(this)
  modal.find('.modal-body #bulan_lalu').html(bulan_lalu + " cm<sup>3</sup>")
  modal.find('.modal-body #bulan_ini').html(bulan_ini + " cm<sup>3</sup>")
  modal.find('.modal-body #pemakaian').html(pemakaian + " cm<sup>3</sup>")
  modal.find('.modal-body #total').html("<strong>" + total + "<strong>")
  modal.find('.modal-body #penagihan').html(penagihan)
  modal.find('.modal-body #status').html(sts)
  modal.find('.modal-body #lunas_at').html(lunas_at)
  modal.find('.modal-body #admin').html(admin + " - " + adm)

})

  $('#add-tagihan').submit(function(e){ // tambah kategori perusahaan
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("penagihan.store", ["id" => $user->id])}}';
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
      success:function(data){
        $('#add-tagihan')[0].reset();
        if(data.status == 'success') {
          successToRelaoad(data.status, data.pesan);
        } else {
          berhasil(data.status, data.pesan);
        }
      },
      error: function(xhr, status, error){
        var error = xhr.responseJSON; 
        if ($.isEmptyObject(error) == false) {
          $.each(error.errors, function(key, value) {
            gagal(key, value);
          });
        }
      } 
    }); 
  });

  function lunas() { // melunaskan tagihan
    $(document).on('click', '#lunas_id', function(){
      Swal.fire({
        title: 'Bayar Tagihan ?',
        text: "Anda akan mengubah status tagihan ini menjadi lunas",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan!',
        timer: 6500
      }).then((result) => {
        if (result.value) {
          var me = $(this),
          url = me.attr('href'),
          token = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url: url,
            method: "POST",
            data : {
              '_method' : 'PUT',
              '_token'  : token
            },
            success:function(data){
              if(data.status == 'success') {
                successToRelaoad(data.status, data.pesan);
              } else {
                berhasil(data.status, data.pesan);
              }
            },
            error: function(xhr, status, error){
              var error = xhr.responseJSON; 
              if ($.isEmptyObject(error) == false) {
                $.each(error.errors, function(key, value) {
                  gagal(key, value);
                });
              }
            } 
          });
        }
      });
    });
  }

  function undo() { // melunaskan tagihan
    $(document).on('click', '#lunas_id', function(){
      Swal.fire({
        title: 'Kembalikan Status Tagihan ?',
        text: "Anda akan mengaktifkan kembali tagihan ini",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Lanjutkan!',
        timer: 6500
      }).then((result) => {
        if (result.value) {
          var me = $(this),
          url = me.attr('href'),
          token = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            url: url,
            method: "POST",
            data : {
              '_method' : 'PUT',
              '_token'  : token
            },
            success:function(data){
              if(data.status == 'success') {
                successToRelaoad(data.status, data.pesan);
              } else {
                berhasil(data.status, data.pesan);
              }
            },
            error: function(xhr, status, error){
              var error = xhr.responseJSON; 
              if ($.isEmptyObject(error) == false) {
                $.each(error.errors, function(key, value) {
                  gagal(key, value);
                });
              }
            } 
          });
        }
      });
    });
  }

  var last = {{$last}};
  function check(bulan_ini)
  {
    console.log(bulan_ini);
    // alert(bulan_ini);
    document.getElementById("pemakaian").innerHTML = "Pemakaian : "+ (bulan_ini-last) +" m<sup>3</sup>";
    var total = eval((bulan_ini-last)*6000);
    var rp = formatRupiah(total, 'Rp. ');
    document.getElementById("hasil").innerHTML = "<strong>Total Tagihan : "+ rp + " -,</strong>";
  }

  function formatRupiah(angka, prefix){
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
    split       = number_string.split(','),
    sisa        = split[0].length % 3,
    rupiah        = split[0].substr(0, sisa),
    ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }

      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    function successToRelaoad(status, pesan) {
      Swal.fire({
        type: status,
        title: pesan,
        showConfirmButton: true,
        button: "Ok"
      }).then((result) => {
        location.reload();
      })
    }

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
  </script>
  @endsection
