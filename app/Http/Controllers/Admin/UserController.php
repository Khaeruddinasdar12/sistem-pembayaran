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

    public function index() //halaman aktif user
    {
        $jml = User::where('status', '1')->count();
        return view('admin.user.index', ['jml' => $jml]);
    }

    public function inaktifIndex() //halaman inaktif user
    {
        $jml = User::where('status', '0')->count();
        return view('admin.user.inaktif-index', ['jml' => $jml]);
    }

    public function store(Request $request)
    {
        $validasi = $this->validate($request, [
            'username'  => 'required|string|unique:users',
            'nama'  => 'required|string',
            'alamat'  => 'required|string',
            'password'  => 'required|string|min:8|confirmed',
        ]);

        $data = new User;
        $data->username = $request->username;
        $data->name = $request->nama;
        if($request->email != '') {
            $validasi = $this->validate($request, [
                'email'  => 'required|email|unique:users',
            ]);
            $data->email = $request->email;
        }
        $data->alamat = $request->alamat;
        $data->status = '1';
        $data->password = bcrypt($request->password);
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah User '
        );
    }

    public function update(Request $request) //ubah data admin
    {
        $validasi = $this->validate($request, [
            'nama' => 'required',
            'alamat' => 'required',
        ]);

        if($request->password != null) {
            $validasi = $this->validate($request, [
                'password' => 'confirmed|min:8',
            ]);
        }

        $id = $request->id;
        $data = User::findOrFail($id);
        $data->name     = $request->nama;
        $data->alamat   = $request->alamat;
        if($request->password != null) {
            $data->password = bcrypt($request->password);
        }

        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengubah User'
        );
    }

    public function status($id)
    {   
        $data = User::find($id);
        if($data == '') {
            return $arrayName = array(
                'status' => 'error',
                'pesan' => 'Id User Tidak Ditemukan '
            );
        }

        if($data->status == '1') {
            $data->status = '0';
        }else {
            $data->status = '1';
        }
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Mengubah Status User '
        );
    }

    public function tableAktifUser() // api table AKTIF users untuk datatable
    {
        $data = User::where('status', '1')->get();
        $admin = Auth::guard('admin')->user()->status;
        if($admin == '0') {
            return $this->kolomAdmin($data);
        } else {
            return $this->kolomPenagih($data);
        }
        
    }

    public function tableInaktifUser() // api table INAKTIF users untuk datatable
    {
        $data = User::where('status', '0')->get();
        $admin = Auth::guard('admin')->user()->status;
        if($admin == '0') {
            return $this->kolomAdmin($data);
        } else {
            return $this->kolomPenagih($data);
        }
    }

    private function kolomAdmin($data)
    {
        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='penagihan/".$data->id."' class='btn btn-info btn-xs' 
            title='laporan user'
            >
            Lihat laporan
            </a>

            <button class='btn btn-secondary btn-xs'
            data-toggle='modal' 
            data-target='#modal-edit-data'
            title='Edit User' 
            href='edit-user/'
            data-id='".$data->id."'
            data-username='".$data->username."'
            data-name='".$data->name."'
            data-email='".$data->email."'
            data-alamat='".$data->alamat."'
            >
            <i class='fa fa-edit'></i>
            </button>

            </button>
            <button class='btn btn-danger btn-xs'
            title='Nonaktifkan User' 
            href='status-user/".$data->id."'
            onclick='status()'
            id='del_id'
            >
            <i class='fa fa-exchange-alt'></i>
            </button>";
            
        })
        ->addColumn('status', function ($data) {
            if($data->status == '0') {
                return "<span class='badge badge-pill badge-warning'>Tidak Aktif</span>";
            } else {
                return "<span class='badge badge-pill badge-success'>Aktif</span>";
            }
        })
        ->rawColumns(['status', 'action'])
        ->addIndexColumn()
        ->make(true);
    }

    private function kolomPenagih($data)
    {
        return Datatables::of($data)
        ->addColumn('action', function ($data) {
            return "
            <a href='penagihan/".$data->id."' class='btn btn-info btn-xs' 
            title='laporan user'
            >
            Lihat laporan
            </a>";
            
        })
        ->addColumn('status', function ($data) {
            if($data->status == '0') {
                return "<span class='badge badge-pill badge-warning'>Tidak Aktif</span>";
            } else {
                return "<span class='badge badge-pill badge-success'>Aktif</span>";
            }
        })
        ->rawColumns(['status', 'action'])
        ->addIndexColumn()
        ->make(true);
    }
}
