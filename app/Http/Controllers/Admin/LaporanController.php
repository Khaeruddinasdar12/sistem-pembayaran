<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Laporan;
use Carbon\Carbon;
use DB;
use PDF;
class LaporanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {

        $bulan = '';
        if(count($request->all()) > 0) {
            if(isset($request->status) && $request->bulan) {
                if(!$request->tahun) {
                    return redirect()->back()->with('error', 'Pilih Tahun Terlebih Dahulu');
                }
                $data = Laporan::with('user:id,name,alamat')
                ->where('status', $request->status)
                ->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun)
                ->paginate(12);
                $bulan = $this->convert($request->bulan);
                $total = Laporan::where('status', $request->status)->sum('total');
            } else if(isset($request->status) && !$request->bulan) {
                $data = Laporan::with('user:id,name,alamat')
                ->where('status', $request->status)
                ->paginate(12);
                $total = Laporan::where('status', $request->status)->sum('total');
            } else if(!isset($request->status) && $request->bulan) {
                if(!$request->tahun) {
                    return redirect()->back()->with('error', 'Pilih Tahun Terlebih Dahulu');
                }
                $data = Laporan::with('user:id,name,alamat')
                ->whereMonth('created_at', $request->bulan)
                ->whereYear('created_at', $request->tahun)
                ->paginate(12);
                $total = Laporan::sum('total');
                $bulan = $this->convert($request->bulan);
            } else {
                $data = Laporan::with('user:id,name,alamat')->paginate(12);
                $total = Laporan::sum('total');
            }
        } else {
            $data = Laporan::with('user:id,name,alamat')->paginate(12);
            $total = Laporan::sum('total');
        }

        // $total = Laporan::sum('total');
        // return $total;
        return view('admin.laporan', [
            'data' => $data, 
            'bulan' => $bulan,
            'grandTotal' => $total,
        ]);
    }

    public function pdf(Request $request) 
    {
        $bulan = '';
        $tahun = '';
        if(isset($request->status) && $request->bulan) {
            if(!$request->tahun) {
                return redirect()->back()->with('error', 'Pilih Tahun Terlebih Dahulu');
            }
            $data = Laporan::with('user:id,name,alamat')
            ->where('status', $request->status)
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();

            $bulan = $this->convert($request->bulan);
            $tahun = $request->tahun;
        } else if($request->status && !$request->bulan) {
            $data = Laporan::with('user:id,name,alamat')
            ->where('status', $request->status)
            ->get();
        } else if(!isset($request->status) && $request->bulan) {
            if(!$request->tahun) {
                return redirect()->back()->with('error', 'Pilih Tahun Terlebih Dahulu');
            }
            $data = Laporan::with('user:id,name,alamat')
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();
            $bulan = $this->convert($request->bulan);
            $tahun = $request->tahun;
        } else {
            $data = Laporan::with('user:id,name,alamat')->get();
        }

            // return $data;
        $pdf   = PDF::loadview('admin.pdf', [
            'data' => $data, 
            'bulan' => $bulan, 
            'tahun' => $tahun
        ]);

        return $pdf->download('laporan-'.$bulan.'-'.$tahun.'.pdf');
    }

    public function convert($bulan)
    {
        switch ($bulan) {
          case '1':
          $i = "Januari";
          break;
          case '2':
          $i = "Februari";
          break;
          case "3":
          $i = "Maret";
          break;
          case '4':
          $i = "April";
          break;
          case '5':
          $i = "Mei";
          break;
          case '6':
          $i = "Juni";
          break;
          case '7':
          $i = "Juli";
          break;
          case '8':
          $i = "Agustus";
          break;
          case '9':
          $i = "September";
          break;
          case '10':
          $i = "Oktober";
          break;
          case '11':
          $i = "November";
          break;
          case '12':
          $i = "Desember";
          break;
          default:
          $i = false;
      }
      return $i;
  }
}
