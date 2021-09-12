@extends('layouts.template')

@section('title')
Inaktif User
@endsection

@section('css')
<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('datatables.min.css')}}"/>
@endsection

@section('content')
<div class="content-header">
</div>
<section class="content">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h2 class="card-title"><i class="fa fa-users"></i> User Tidak Aktif ({{$jml}})</h2>
        </div>
        <div class="card-body">          
          <div class="table-responsive-sm">
            <table id="tabel_user" class="table table-bordered" style="width:100% !important; ">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Alamat</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>  
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

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

 function status() { //ubah status user
   $(document).on('click', '#del_id', function(){
    Swal.fire({
      title: 'Aktifkan User ?',
      text: "Akun ini akan di aktifkan!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya!',
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
              berhasil(data.status, data.pesan);
              $('#tabel_user').DataTable().ajax.reload();
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

 tabel = $(document).ready(function(){
  $('#tabel_user').DataTable({
    "processing": true,

    "serverSide": true,
    "deferRender": true,
    "ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.user.inaktif")}}', // URL file untuk proses select datanya
                "type": "GET"
              },
              "columns": [
              { data: 'DT_RowIndex', name:'DT_RowIndex'},
              { "data": "name" },
              { "data": "email" },
              { "data": "alamat" },
              { "data": "status" },
              { "data": "action" },
              ]
            });
});
</script>
@endsection