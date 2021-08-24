<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use DataTables;

class ManagePenagihController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.manage-penagih.index');
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama'  => 'required|string',
            'email'  => 'required|email|unique:admins',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $data = new Admin;
        $data->name = $request->nama;
        $data->email = $request->email;
        $data->status= '1'; //penagih
        $data->password = bcrypt($request->password);
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Penagih '
        );
    }

    public function tablePenagih() // api table admins untuk datatable
    {
        $data = Admin::where('status', '1')->get();

        return Datatables::of($data)
        // ->addColumn('action', function ($data) {
        //     return "
        //     <a href='berita/edit/".$data->id."' class='btn btn-success btn-xs'>
        //     <i class='fa fa-edit'></i>
        //     </a>

        //     <button class='btn btn-danger btn-xs'
        //     title='Hapus Berita' 
        //     href='berita/delete-berita/".$data->id."'
        //     onclick='hapus_data()'
        //     id='del_id'
        //     >
        //     <i class='fa fa-trash'></i>
        //     </button>";
        // })
        ->addIndexColumn() 
        ->make(true);
    }
}
