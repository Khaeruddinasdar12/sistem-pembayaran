<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Laporan;
use Carbon\Carbon;
use Auth;
class PenagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index($id)
    {
        $user = User::findOrFail($id);
        $laporan = Laporan::with('admin:id,name,status')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->paginate(20);

        $last = Laporan::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->limit(1)->first();
        if($last == '') {
            $last = 0;
        } else {
            $last = $last->meter_bulan_ini;
        }
        // return $last->meter_bulan_ini;
        return view('admin.penagihan.index', [
            'user'      => $user,
            'laporan'   => $laporan,
            'last'      => $last
        ]);
    }

    public function store(Request $request, $id)
    {
        $date = Carbon::now(); 
        $validasi = $this->validate($request, [
            'meter_bulan_ini'  => 'required|numeric',
        ]);
        
        $last = Laporan::where('user_id', $id)
        ->orderBy('created_at', 'desc')
        ->limit(1)->first();

        $pesan = '';
        $data = new laporan;
        if($last == '') {
            $data->meter_bulan_lalu = 0;
            $meter_bulan_lalu = 0;
        } else {
            if($request->meter_bulan_ini < $last->meter_bulan_ini) {
                return $arrayName = array(
                    'status' => 'error',
                    'pesan' => 'Meter bulan ini kurang dari meter bulan lalu.'
                );
            }
            $data->meter_bulan_lalu = $last->meter_bulan_ini;
            $meter_bulan_lalu = $last->meter_bulan_ini;
        }
        
        $data->meter_bulan_ini = $request->meter_bulan_ini;
        $data->pemakaian = $request->meter_bulan_ini - $meter_bulan_lalu;
        $data->total = ($request->meter_bulan_ini - $meter_bulan_lalu)*6000;
        if($request->cek == '1') {
            $data->status = '1';
            $data->lunas_at = $date;
            $pesan = 'Dan Melunasi Tagihan.';
        }
        $data->user_id = $id;
        $data->updated_by = Auth::guard('admin')->user()->id;
        $data->save();

        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Berhasil Menambah Tagihan '.$pesan
        );
    }

    public function update($id)
    {
        $data = Laporan::find($id);
        $data->status = '1';
        $data->save();
        return $arrayName = array(
            'status' => 'success',
            'pesan' => 'Tagihan Dilunaskan'
        );
    }
}
