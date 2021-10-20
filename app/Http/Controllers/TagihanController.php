<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laporan;
use Auth;
use PDF;
class TagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $auth_id = Auth::user()->id;
        $data = Laporan::where('user_id', $auth_id)
        ->with('admin:id,name')
        ->where('status', '0')
        ->orderBy('created_at', 'asc')
        ->paginate(10);
        return view('user.tagihan', ['data' => $data]);
    }

    public function riwayat()
    {
        $auth_id = Auth::user()->id;
        $data = Laporan::where('user_id', $auth_id)
        ->with('admin:id,name')
        ->where('status', '1')
        ->orderBy('created_at', 'asc')
        ->paginate(10);
        return view('user.riwayat', ['data' => $data]);
    }

    public function pdf($id)
    {
        $auth_id = Auth::user()->id;
        $data = Laporan::where('user_id', $auth_id)
        ->where('id', $id)
        ->with('admin:id,name')
        ->where('status', '0')
        ->orderBy('created_at', 'asc')
        ->first();
        // return $data;
        $pdf   = PDF::loadview('user.pdf-test', ['dt' => $data]);

        return $pdf->download('kwitansi '.$data->created_at.'.pdf');
    }
}
