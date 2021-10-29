<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Laporan;
use Carbon\Carbon;
use Auth;
use Mail;
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
        
        $data->user_id = $id;
        $data->updated_by = Auth::guard('admin')->user()->id;
        

        if($request->cek == '1') { //lunasi sekarang
            $data->status = '1';
            $data->lunas_at = $date;
            $pesan = 'Dan Melunasi Tagihan.';
            $data->save();
        }

        $data->save();
            //send email
        $dt = Laporan::with('user')->with('admin')->find($data->id);
        if($dt->user->email != '') {
            $email = $dt->user->email;
                $send = array( //data yang dikirim
                    'name' => $dt->user->name,
                    'meter_bulan_ini' => $dt->meter_bulan_ini,
                    'total' => $dt->total,
                    'created_at' => $dt->created_at,
                    'admin' => $dt->admin->name,
                    'status' => $dt->status,
                );
                $judul= config('app.name');
                Mail::send('email', $send, function($mail) use($email, $judul) {
                    $mail->to($email, 'no-reply')
                    ->subject($judul);
                    $mail->from('payment@gmail.com', config('app.name'));        
                });
                if (Mail::failures()) {
                    return $arrayName = array('status' => 'error' , 'pesan' => 'Gagal menigirim email' );
                }
            }//end send email

            return $arrayName = array(
                'status' => 'success',
                'pesan' => 'Berhasil Menambah Tagihan '.$pesan
            );
        }

        public function update($id)
        {
            $data = Laporan::with('user')->with('admin')->find($id);
            if($data->status == '1') {
                $data->status = '0';
                $data->save();
                return $arrayName = array(
                    'status' => 'success',
                    'pesan' => 'Berhasil Mengembalikan Status Tagihan'
                );
            } else {
                $data->status = '1';
                $data->save();
                if($data->user->email != '') {
                    $email = $data->user->email;
                    $send = array( //data yang dikirim
                        'name' => $data->user->name,
                        'meter_bulan_ini' => $data->meter_bulan_ini,
                        'total' => $data->total,
                        'created_at' => $data->created_at,
                        'admin' => $data->admin->name,
                        'status' => $data->status,
                    );
                    $judul= config('app.name');
                    Mail::send('email', $send, function($mail) use($email, $judul) {
                        $mail->to($email, 'no-reply')
                        ->subject($judul);
                        $mail->from('payment@gmail.com', config('app.name'));        
                    });
                    if (Mail::failures()) {
                        return $arrayName = array('status' => 'error' , 'pesan' => 'Gagal menigirim email' );
                    }
                }
            }

            return $arrayName = array(
                'status' => 'success',
                'pesan' => 'Tagihan Dilunaskan'
            );
        }
    }
