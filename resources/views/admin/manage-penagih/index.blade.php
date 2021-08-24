@extends('layouts.template')

@section('title')
Manage Penagih
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
          <h2 class="card-title"><i class="fa fa-users"></i> Manage Penagih</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="float-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-penagih"><i class="fa fa-plus"></i> Tambah Penagih</button>
          </div> 
          <br>
          <br>
          

          <div class="table-responsive-sm">
            <table id="tabel_penagih" class="table table-bordered" style="width:100% !important; ">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama</th>
                  <th>Email</th>
                </tr>
              </thead>  
            </table>
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

<!-- MODAL -->

<!-- Modal Tambah -->
<div class="modal fade bd-example-modal" id="tambah-penagih" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="add">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Penagih </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" name="password" placeholder="minimal 8 digit">
          </div>
          <div class="form-group">
            <label>Password Confirmation</label>
            <input type="password" class="form-control" name="password_confirmation">
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
<!-- END MODALS -->
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

  $('#add').submit(function(e){
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("penagih.store")}}';
    $.ajax({
      url: endpoint,
      method: "POST",
      data: request,
      contentType: false,
      cache: false,
      processData: false,
            // dataType: "json",
            success:function(data){
              $('#add')[0].reset();
              $('#tabel_penagih').DataTable().ajax.reload();
              $('#tambah-penagih').modal('hide');
              berhasil(data.status, data.pesan);
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