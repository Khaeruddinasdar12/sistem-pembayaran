@extends('layouts.template')

@section('title')
Aktif User
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
          <h2 class="card-title"><i class="fa fa-users"></i> Aktif User ({{$jml}})</h2>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          @if(Auth::guard('admin')->user()->status == '0')
          <div class="float-right">
            <button class="btn btn-primary" data-toggle="modal" data-target="#tambah-user"><i class="fa fa-plus"></i> Tambah User</button>
          </div> 
          <br>
          <br>
          @else 
          @endif

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

<!-- MODAL -->

<!-- Modal Tambah -->
<div class="modal fade bd-example-modal" id="tambah-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" id="add">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah User </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="username">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control" name="nama">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="test" class="form-control" name="alamat">
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

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Pengecer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="post" id="edit-user">
        <div class="modal-body">
          @csrf
          {{ method_field('PUT') }}
          <input type="hidden" name="id" id="hidden-id">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Username:</label>
            <input type="text" class="form-control" id="username" name="username" disabled>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Email</label>
            <input type="text" class="form-control" id="email" disabled>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nama:</label>
            <input type="text" class="form-control" id="name" name="nama">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Alamat:</label>
            <textarea class="form-control" id="alamat" name="alamat"></textarea>
          </div>
          <div class="row">
            <div class="col-6">
              <label>Password</label>
              <input type="password" class="form-control" name="password" placeholder="min. 8 digit">
            </div>
            <div class="col-6">
              <label>Password Confirmation</label>
              <input type="password" class="form-control" name="password_confirmation">
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Edit -->
<!-- END MODALS -->
@endsection

@section('js')
<script type="text/javascript" src="{{asset('datatables.min.js')}}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

<script type="text/javascript">

  $('#modal-edit-data').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var href = button.data('href') 
  var id = button.data('id')
  var username = button.data('username') 
  var name = button.data('name')
  var email = button.data('email')
  var alamat = button.data('alamat')  
  var modal = $(this)
  modal.find('.modal-body #edit-pengecer').attr('action', href)
  modal.find('.modal-body #hidden-id').val(id)
  modal.find('.modal-body #username').val(username)
  modal.find('.modal-body #name').val(name)
  modal.find('.modal-body #email').val(email)
  modal.find('.modal-body #alamat').val(alamat)
})

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
        title: 'Nonaktifkan sementara ?',
        text: "Akun ini akan di nonaktifkan sementara!",
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

   $('#add').submit(function(e){
    e.preventDefault();

    var request = new FormData(this);
    var endpoint= '{{route("user.store")}}';
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
              $('#tabel_user').DataTable().ajax.reload();
              $('#tambah-user').modal('hide');
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

    $('#edit-user').submit(function(e){ //edit pengecer
      e.preventDefault();
      var request = new FormData(this);
      var endpoint= '{{route("user.edit")}}';
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
              $('#tabel_user').DataTable().ajax.reload();
              $('#modal-edit-data').modal('hide');
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
      $('#tabel_user').DataTable({
        "processing": true,

        "serverSide": true,
        "deferRender": true,
        "ordering": true,
        // "scrollX" : true,
        "order": [[ 0, 'desc' ]],
        "aLengthMenu": [[10, 25, 50],[ 10, 25, 50]],
        "ajax":  {
                "url":  '{{route("table.user.aktif")}}', // URL file untuk proses select datanya
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