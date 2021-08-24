<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\User;
use Auth;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.user.index');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'email'  => 'required|email|unique:users',
            'alamat'  => 'required|string',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $data = new User;
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->alamat = $request->alamat;
        $data->password = bcrypt($request->password);
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah User '
        );
    }

    public function tableUser() // api table users untuk datatable
    {
        $data = User::get();

        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='penagihan/".$data->id."' class='btn btn-info btn-xs' 
            title='laporan user'
            >
            Lihat laporan
            </a>

            <a href='berita/edit/".$data->id."' class='btn btn-success btn-xs'>
            <i class='fa fa-edit'></i>
            </a>

            <button class='btn btn-danger btn-xs'
            title='Hapus Berita' 
            href='berita/delete-berita/".$data->id."'
            onclick='hapus_data()'
            id='del_id'
            >
            <i class='fa fa-trash'></i>
            </button>";
        })
        ->addIndexColumn() 
        ->make(true);
    }
}
